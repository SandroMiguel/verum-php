<?php

/**
 * Boolean Value rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.0.1 (13/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

/**
 * Class BooleanValue | src/Rules/BooleanValue.php
 * Checks whether the value is a boolean value.
 * Returns true for 1/0, '1'/'0', 'on'/'off', 'yes'/'no', true/false.
 */
final class BooleanValue extends Rule
{
    /**
     * BooleanValue constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 1.0.0 (16/05/2020)
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
     * @version 1.0.0 (16/05/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        return is_bool(
            filter_var(
                $this->fieldValue,
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            )
        );
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 1.0.0 (15/05/2020)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->fieldLabel];
    }
}
