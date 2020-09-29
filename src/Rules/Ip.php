<?php

/**
 * IP rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   2.0.1 (13/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

/**
 * Class Ip | src/Rules/Ip.php
 * Checks whether the value is a valid IP address.
 */
final class Ip extends Rule
{
    /**
     * Ip constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 1.0.0 (10/05/2020)
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
     * @version 2.0.0 (28/05/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if ($this->fieldValue === '') {
            return true;
        }

        return filter_var($this->fieldValue, FILTER_VALIDATE_IP) !== false;
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
