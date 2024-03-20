<?php

/**
 * Validator.
 *
 * @package Verum-PHP
 * @license MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @link https://github.com/SandroMiguel/verum-php
 * @version 4.2.0 (2024-03-19)
 */

declare(strict_types=1);

namespace Verum;

use Verum\Enum\LangEnum;
use Verum\Rules\RuleFactory;

/**
 * Class Validator | src/Validator.php | Input validation
 */
final class Validator
{
    /** @var bool Debug mode. */
    private bool $debugMode;

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
     * @var array<string, string|array<string, string>> Error messages
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
     * @param string|null $lang Language.
     * @param bool|null $debugMode Debug mode.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 1.0.1 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public function __construct(
        array $fieldValues,
        array $fieldRules,
        ?string $lang = 'en',
        ?bool $debugMode = false,
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
        $this->debugMode = $debugMode;
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
     */
    public function validate(): bool
    {
        $isValid = true;

        // For each field rules
        foreach ($this->fieldRules as $fieldName => $fieldConfig) {
            if ($this->debugMode) {
                echo "\n--------------------";
                echo "\n1 Ruled field name    >>>> " . $fieldName;
                echo "\n1.1 Field config >>>> ";
                \var_export($fieldConfig);
            }

            $label = $this->getLabel($fieldConfig['label'] ?? null);

            if ($this->debugMode) {
                echo "\n1.2 fieldValues (all) >>>> ";
                \var_export($this->fieldValues);
            }

            // For each field rule and their respective values
            foreach ($fieldConfig['rules'] as $key => $value) {
                [$ruleName, $ruleValues] = $this->getRuleData($key, $value);

                if ($this->debugMode) {
                    echo "\n-";
                    echo "\n2 Rule name     >>>> " . $ruleName;
                }

                // Check if is a multi-name field
                $isMultiNameField = \strpos($fieldName, '.') !== false;

                if (!$isMultiNameField) {
                    $fieldValue = $this->fieldValues[$fieldName] ?? null;
                } else {
                    $fieldValue = [];
                    // Filter by base field name
                    $baseFieldName = \explode('.', $fieldName)[0];
                    $fieldValues = \array_filter(
                        $this->fieldValues,
                        static fn ($key) => \strpos($key, $baseFieldName) === 0,
                        \ARRAY_FILTER_USE_KEY
                    );

                    if ($this->debugMode) {
                        echo "\n2.1 Field values (filtered) >>>> \n";
                        \var_export($fieldValues);
                    }

                    foreach ($fieldValues as $fullFieldName => $value) {
                        [$baseFieldName] = \explode('.', $fullFieldName);

                        if (\strpos($fullFieldName, $baseFieldName) !== 0) {
                            continue;
                        }
                        
                        $fieldValue[$fullFieldName] = $value;
                    }
                }

                $fieldValues = \is_array($fieldValue)
                    ? $fieldValue
                    : [$fieldName => $fieldValue];

                if ($this->debugMode) {
                    echo "\n2.2 fieldValues >>>> ";
                    \var_export($fieldValues);
                }

                // For each field values
                foreach ($fieldValues as $fullFieldName => $fieldValue) {
                    if ($this->debugMode) {
                        echo "\n-";
                        echo "\n3 Full field name    >>>> " . $fullFieldName;
                    }

                    $baseFieldName = \strpos($fullFieldName, '.')
                        ? \explode('.', $fullFieldName)[0]
                        : $fullFieldName;

                    if ($this->debugMode) {
                        echo "\n3.1 Base field name    >>>> " . $baseFieldName;
                    }

                    if (\strpos($fieldName, $baseFieldName) !== 0) {
                        if ($this->debugMode) {
                            echo "\n4 Rule not applicable for this field";
                        }

                        continue;
                    }

                    if ($this->debugMode) {
                        echo "\n3.2 Rule applicable: " . $fullFieldName . ' - ' . $ruleName;
                        echo "\n3.3 Field value   >>>> " . ($fieldValue === null ? 'NULL' : $fieldValue);
                    }

                    $rule = RuleFactory::loadRule(
                        $this,
                        $fieldValue,
                        $ruleValues,
                        $baseFieldName,
                        $ruleName,
                        $label
                    );

                    if ($rule->validate()) {
                        if ($this->debugMode) {
                            echo "\n4 Rule passed ✔️\n";
                        }

                        continue;
                    }

                    $errorMessage = $this->getErrorMessage(
                        $fullFieldName,
                        $ruleName,
                        $rule->getErrorMessageParameters()
                    );

                    $this->addError(
                        $fullFieldName,
                        $label,
                        $errorMessage
                    );

                    if ($this->debugMode) {
                        echo "\n4 Rule failed ❌\n";
                    }
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
     * @version 1.1.0 (2021/05/26)
     * @since Verum 1.0.0
     */
    public function addError(
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
        } catch (\Throwable $ex) {
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
     * Retrieves the name and values of a validation rule.
     * E.g. between => [3, 15]
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
