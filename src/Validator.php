<?php

/**
 * Validator.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.4 (2021/01/25)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum;

use Verum\ArrayHelper;
use Verum\Enum\LangEnum;
use Verum\Exception\ValidatorException;
use Verum\Rules\RuleFactory;

/**
 * Class Validator | src/Validator.php | Input validation
 */
final class Validator
{
    /**
     * [
     *   'some_field_a' => 'some value A',
     *   'some_field_b' => 'some value B',
     * ]
     *
     * @var array<mixed> Input field data
     * */
    private $fieldValues = [];

    /**
     *  [
     *      'field_name_1' => [
     *          'label' => 'Label name',
     *          'rules' => [
     *              [0] => 'required',
     *              'min_length' => 5,
     *          ],
     *      ],
     *      'field_name_2' => [ ... ],
     *      ...
     *  ]
     *
     * @var array<mixed> Field rules
     */
    private $fieldRules = [];

    /**
     *  [
     *      'required' => [
     *           'withLabel' => 'The "{param:1}" field is required.',
     *           'withoutLabel' => 'This field is required.',
     *      ],
     *      'min_length' => [
     *           'withLabel' => 'The "{param:2}" field must be at least {param:1} characters long.',
     *           'withoutLabel' => 'This field must be at least {param:1} characters long.',
     *      ],
     *      ...
     *  ]
     *
     * @var array<string, array<string, string>|string> Error messages
     */
    private $messages = [];

    /**
     *  [
     *      'field_name_1' => [
     *          'label' => 'Field label 1',
     *          'rules' => [
     *              'between_length' => 'The length must be between %1$s and %2$s characters.',
     *              'required' => 'This field is required.',
     *          ],
     *      ],
     *      'field_name_2' => [ ... ],
     *      ...
     *  ]
     *
     * @var array<mixed> Errors list
     */
    private $errors = [];

    /** @var string $language Language */
    private $language;

    /**
     * Validator constructor.
     *
     * @param array<mixed> $fieldValues Input field data.
     * @param array<mixed> $fieldRules Field rules.
     * @param string $lang Language.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 1.0.1 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public function __construct(
        array $fieldValues,
        array $fieldRules,
        string $lang = 'en'
    ) {
        if ($this->isEmptyArray($fieldValues)) {
            throw ValidatorException::noFields();
        }
        if ($this->isEmptyArray($fieldRules)) {
            throw ValidatorException::noRules();
        }
        if (!in_array($lang, LangEnum::getConstants())) {
            throw ValidatorException::invalidArgument(
                '$lang',
                $lang,
                'Language not available'
            );
        }

        $this->fieldValues = $fieldValues;
        $this->fieldRules = $fieldRules;
        $this->language = $lang;
        $this->loadMessages($lang);
    }

    /**
     * Adds a simple custom error message.
     *
     * @param string $rule Rule name.
     * @param string $message Message.
     *
     * @version 2.0.0 (17/04/2020)
     * @since   Verum 1.0.0
     */
    public function addSimpleCustomMessage(
        string $rule,
        string $message
    ): Validator {
        $this->messages = array_merge($this->messages, [$rule => $message]);
        return $this;
    }

    /**
     * Adds a custom error message to the field with and without a label.
     *
     * @param string $rule Rule name.
     * @param string $messageWithLabel Message to show if the field has a label.
     * @param string $messageWithoutLabel Message to show if the field does not have a label.
     *
     * @version 2.0.0 (17/06/2020)
     * @since   Verum 1.0.0
     */
    public function addCustomMessage(
        string $rule,
        string $messageWithLabel,
        string $messageWithoutLabel
    ): Validator {
        $this->messages = array_merge(
            $this->messages,
            [
                $rule => [
                    'withLabel' => $messageWithLabel,
                    'withoutLabel' => $messageWithoutLabel,
                ],
            ]
        );
        return $this;
    }

    /**
     * Adds multiple custom error messages.
     *
     * @param array<string, array<string, string>|string> $message Message.
     *
     * @version 1.0.0 (30/04/2020)
     * @since   Verum 1.0.0
     */
    public function addCustomMessages(array $message): Validator
    {
        $this->messages = array_merge($this->messages, $message);
        return $this;
    }

    /**
     * Check fields for errors using the validation rules.
     *
     * @return bool Returns TRUE if all fields pass validation, FALSE otherwise.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.1.0 (17/06/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        $isValid = true;

        foreach ($this->fieldRules as $fieldName => $fieldConfig) {
            if (!$this->hasRules($fieldConfig['rules'])) {
                continue;
            }

            $label = $this->getLabel($fieldConfig['label'] ?? null);
            $fieldValue = $this->fieldValues[$fieldName] ?? null;

            foreach ($fieldConfig['rules'] as $key => $value) {
                [$ruleName, $ruleValues] = $this->getRuleData($key, $value);

                $rule = RuleFactory::loadRule(
                    $this,
                    $fieldValue,
                    $ruleValues,
                    $fieldName,
                    $ruleName,
                    $label
                );

                if (!$rule->validate()) {
                    $errorMessage = $this->getErrorMessage(
                        $fieldName,
                        $ruleName,
                        $rule->getErrorMessageParameters()
                    );

                    $this->addError(
                        $fieldName,
                        $label,
                        $errorMessage
                    );
                    $isValid = false;
                }
            }
        }

        return $isValid;
    }

    /**
     * Getter ('fieldValues')
     *
     * @return array<mixed>
     */
    public function getFieldValues(): array
    {
        return $this->fieldValues;
    }

    /**
     * Getter ('fieldRules')
     *
     * @return array<mixed>
     */
    public function getFieldRules(): array
    {
        return $this->fieldRules;
    }

    /**
     * Errors messages.
     *
     * @return array<mixed> Returns the error messages.
     *
     * @version 1.0.0 (30/04/2020)
     * @since   Verum 1.0.0
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Check if an array is empty.
     *
     * @param array<mixed> $array Array.
     *
     * @return bool Returns TRUE if the array is empty, FALSE otherwise.
     *
     * @version 1.0.0 (24/06/2020)
     * @since   Verum 1.0.0
     */
    private function isEmptyArray(array $array): bool
    {
        if (count($array)) {
            return false;
        }

        return true;
    }

    /**
     * Builds the Error Message.
     *
     * @param string $fieldName Field name.
     * @param string $ruleName Rule name.
     * @param array<mixed> $ruleValues Rule values.
     *
     * @return array<string, string> Returns the array with the rule name and the error message.
     *
     * @version 2.0.0 (16/06/2020)
     * @since   Verum 1.0.0
     */
    private function getErrorMessage(
        string $fieldName,
        string $ruleName,
        array $ruleValues
    ): array {
        return [
            $ruleName => $this->formatMessage(
                $this->getMessage($fieldName, $ruleName),
                $ruleValues
            ),
        ];
    }

    /**
     * Load rule messages.
     *
     * @param string $lang Language.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 1.0.0 (30/04/2020)
     * @since   Verum 1.0.0
     */
    private function loadMessages(string $lang): void
    {
        $messagesPath = __DIR__ . "/I18n/{$lang}.php";
        if (!file_exists($messagesPath)) {
            throw ValidatorException::noTranslation($lang);
        }
        $this->messages = include $messagesPath;
    }

    /**
     * Adds an error.
     *
     * @param string $fieldName Field name.
     * @param string $label Field label.
     * @param array<string, string> $error Error message (e.g.: ['required' => 'This field is required']).
     *
     * @version 1.0.1 (16/06/2020)
     * @since   Verum 1.0.0
     */
    private function addError(
        string $fieldName,
        ?string $label,
        array $error
    ): void {
        $this->errors = array_replace_recursive(
            $this->errors,
            [
                $fieldName => [
                    'label' => $label,
                    'rules' => $error,
                ],
            ]
        );
    }

    /**
     * Format Rule Message.
     *
     * @param string $ruleMessage Rule message.
     * @param array<int, mixed> $args Arguments - Error message parameters.
     *
     * @return string Returns the message with the placeholder values ​​filled in.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 1.1.1 (2020/09/29)
     * @since   Verum 1.0.0
     */
    private function formatMessage(string $ruleMessage, array $args): string
    {
        $format = preg_replace('/{param:(\d)}/', '%$1$s', $ruleMessage);
        try {
            if (is_array($args[0])) {
                $args[0] = ArrayHelper::arrayToString($args[0]);
            }
            return vsprintf($format, $args);
        } catch (\Exception $ex) {
            throw ValidatorException::invalidRuleMessageArgument(
                $ruleMessage,
                $args,
                (int) $ex->getCode(),
                $ex
            );
        }
    }

    /**
     * Rule Message.
     *
     * @param string $fieldName Field name.
     * @param string $ruleName Rule name.
     *
     * @return string Returns the message.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.0.2 (16/06/2020)
     * @since   Verum 1.0.0
     */
    private function getMessage(string $fieldName, string $ruleName): string
    {
        if (!isset($this->messages[$ruleName])) {
            throw ValidatorException::ruleMessageNotFound($ruleName);
        }

        if (isset($this->fieldRules[$fieldName]['label'])) {
            return $this->messages[$ruleName]['withLabel']
                ?? $this->messages[$ruleName];
        }

        return $this->messages[$ruleName]['withoutLabel']
            ?? $this->messages[$ruleName];
    }

    /**
     * Get Rule Name and Values.
     *
     * @param mixed $key Key.
     * @param mixed $value Value.
     *
     * @return array<mixed> Returns the Rule Name and the Rule Values.
     *
     * @version 1.0.0 (02/05/2020)
     * @since   Verum 1.0.0
     */
    private function getRuleData($key, $value): array
    {
        if (is_numeric($key)) {
            // The rule has no values (e.g. required).
            $ruleName = $value;
            $ruleValues = [];
        } else {
            // The rule has one or mores values (e.g. between => [3, 15]).
            $ruleName = $key;
            $ruleValues = is_array($value) ? $value : [$value];
        }

        return [
            $ruleName,
            $ruleValues,
        ];
    }

    /**
     * Get label.
     *
     * @param mixed $label Label.
     *
     * @return string|null Returns the label or NULL.
     *
     * @version 1.0.1 (2021/01/25)
     * @since   Verum 1.0.0
     */
    private function getLabel($label = null): ?string
    {
        if (is_array($label)) {
            return $label[$this->language];
        }

        return $label;
    }

    /**
     * Checks if the field has defined rules.
     *
     * @param array<mixed> $rules Rules.
     *
     * @return bool Returns TRUE if has rules, FALSE otherwise.
     *
     * @version 1.0.1 (25/06/2020)
     * @since   Verum 1.0.0
     */
    private function hasRules(array $rules): bool
    {
        return count($rules) > 0;
    }
}
