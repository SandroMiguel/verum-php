<?php

/**
 * Integer rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package Verum-PHP
 * @license MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2022 Sandro
 * @since Verum-PHP 2.1.0
 * @version 1.0.0 (2022/07/13)
 * @link https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

/**
 * Class Integer | src/Rules/Integer.php
 * Checks whether the value is integer.
 */
final class Integer extends Rule
{
    /**
     * Integer constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 1.0.0 (2022/07/13)
     * @since Verum 2.1.0
     */
    public function __construct(mixed $fieldValue)
    {
        $this->fieldValue = $fieldValue;
    }

    /**
     * Validates the field value against the rule.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @version 1.0.0 (2022/07/13)
     * @since Verum 2.1.0
     */
    public function validate(): bool
    {
        if ($this->fieldValue === null || $this->fieldValue === '') {
            return true;
        }

        return is_int($this->fieldValue);
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 1.0.0 (2022/07/13)
     * @since Verum 2.1.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->fieldLabel];
    }
}
