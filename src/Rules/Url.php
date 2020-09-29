<?php

/**
 * URL rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   2.0.2 (14/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

/**
 * Class Url | src/Rules/Url.php
 * Checks whether the value is a valid URL.
 */
final class Url extends Rule
{
    /**
     * Url constructor.
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
     * @version 2.0.0 (30/05/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if ($this->fieldValue === '') {
            return true;
        }

        return filter_var($this->fieldValue, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 1.0.1 (14/06/2020)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->fieldLabel];
    }
}
