<?php

/**
 * RequiredIfNot rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 2.0.0
 * @version   1.0.1 (2021/01/26)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exceptions\ValidatorException;

/**
 * Class RequiredIfNot | src/Rules/RequiredIfNot.php
 * Checks whether the value is not empty, whenever other Fieldname is empty
 */
final class RequiredIfNot extends Rule
{
    /** @var string Field Name to compare */
    private $fieldNameDepends;

    /** @var string Field value to compare */
    private $fieldValueDepends;

    /**
     * RequiredIfNot constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 1.0.0 (2020/08/18)
     * @since   Verum 1.0.0
     */
    public function __construct($fieldValue)
    {
        $this->fieldValue = $fieldValue;
    }

    /**
     * Validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 1.0.1 (2021/01/26)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "requiredIfNot": the rule value is mandatory'
            );
        }
        $this->fieldNameDepends = $this->ruleValues[0];

        $fieldValues = $this->validator->getFieldValues();
        if (array_key_exists($this->fieldNameDepends, $fieldValues)) {
            $this->fieldValueDepends = $fieldValues[$this->fieldNameDepends];
            $isEmptyDepends = $this->isEmpty($this->fieldValueDepends);
        } else {
            // no value was submitted for the dependent field (may be legit e.g. for an unchecked checkbox)
            $isEmptyDepends = true;
        }

        if ($isEmptyDepends) {
            $isValid = !$this->isEmpty($this->fieldValue);
            return $isValid;
        }
        return true;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 1.0.0 (2020/08/18)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->fieldLabel];
    }



    /**
     * Checks whether the value is empty
     *
     * @param mixed $value Value to check.
     *
     * @return bool Returns TRUE if empty, FALSE otherwise.
     *
     * @version 1.0.0 (2020/08/18)
     * @since   Verum 1.0.x
     */
    private function isEmpty($value): bool
    {
        if (
            empty($value)
            && $value !== '0'
            && $value !== 0
            && $value !== []
        ) {
            return true;
        }
        return false;
    }
}
