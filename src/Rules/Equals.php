<?php

/**
 * Equals rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.3 (2020/08/23)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exceptions\ValidatorException;

/**
 * Class Equals | src/Rules/Equals.php
 * Checks whether the value is equal to another.
 */
final class Equals extends Rule
{
    /** @var string Field Name to compare */
    private $fieldNameToCompare;

    /** @var string|null Field value to compare */
    private $fieldValueToCompare;

    /** @var string|null First field label */
    private $labelNameA;

    /** @var string|null Second field label */
    private $labelNameB;

    /**
     * Equals constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 3.0.0 (2020/06/09)
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
     * @version 2.0.2 (2020/08/18)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "equals": the rule value is mandatory'
            );
        }
        $this->fieldNameToCompare = $this->ruleValues[0];

        if ($this->fieldValue === null || $this->fieldValue === '') {
            return true;
        }

        $fieldValues = $this->validator->getFieldValues();
        if (array_key_exists($this->fieldNameToCompare, $fieldValues)) {
            $this->fieldValueToCompare = $fieldValues[$this->fieldNameToCompare];
        } else {
            // no value was submitted for the dependent field (may be legit e.g. for an unchecked checkbox)
            $this->fieldValueToCompare = null;
        }

        $this->labelNameA = $this
            ->validator
            ->getFieldRules()[$this->fieldNameToCompare]['label'] ?? null;
        $this->labelNameB = $this
            ->validator
            ->getFieldRules()[$this->fieldNameUnderTest]['label'] ?? null;

        return $this->fieldValue === $this->fieldValueToCompare;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string|null> Returns the parameters for the error message.
     *
     * @version 1.0.0 (2020/05/15)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->labelNameA, $this->labelNameB];
    }
}
