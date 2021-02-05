<?php

/**
 * Max Length rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.0 (2020/09/21)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exception\ValidatorException;

/**
 * Class MaxLength | src/Rules/MaxLength.php
 * Checks whether the number of characters of the value does not exceed a given value.
 */
final class MaxLength extends Rule
{
    /** @var int Max length value */
    private $maxLength;

    /**
     * MaxLength constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.0.0 (2020/06/10)
     * @since   Verum 1.0.0
     */
    public function __construct($fieldValue)
    {
        $this->fieldValue = $fieldValue;
    }

    /**
     * Validates the field value against the rule.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.0.0 (2020/09/21)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "max_length": the rule value is mandatory'
            );
        }
        if (!is_int($this->ruleValues[0])) {
            throw ValidatorException::noIntegerValue($this->ruleValues[0]);
        }

        $this->maxLength = $this->ruleValues[0];

        if ($this->fieldValue === null) {
            return true;
        }

        if (
            !isset($this->fieldValue)
            || is_array($this->fieldValue)
            || mb_strlen((string) $this->fieldValue) > $this->maxLength
        ) {
            return false;
        }

        return true;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, mixed> Returns the parameters for the error message.
     *
     * @version 2.0.0 (2020/06/16)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->maxLength, $this->fieldLabel];
    }
}
