<?php

/**
 * Float Number rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   2.0.2 (2020/10/19)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

/**
 * Class FloatNumber | src/Rules/FloatNumber.php
 * Checks whether the value is a floating point number.
 */
final class FloatNumber extends Rule
{
    /**
     * Float constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 1.0.0 (2020/05/16)
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
     * @version 2.0.1 (2020/10/19)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if ($this->fieldValue === null || $this->fieldValue === '') {
            return true;
        }
        if (
            !is_numeric($this->fieldValue)
            || !strpos((string) $this->fieldValue, '.')
        ) {
            return false;
        }

        return true;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 1.1.0 (2020/06/14)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->fieldLabel];
    }
}
