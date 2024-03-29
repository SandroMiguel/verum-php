<?php

/**
 * Email rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   2.0.2 (2020/10/09)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

/**
 * Class Email | src/Rules/Email.php
 * Checks whether the value has a valid email format.
 */
final class Email extends Rule
{
    /**
     * Email constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 1.0.0 (2020/05/09)
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
     * @version 2.0.1 (2020/10/09)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if ($this->fieldValue === null || $this->fieldValue === '') {
            return true;
        }

        return filter_var($this->fieldValue, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 1.0.0 (2020/05/15)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->fieldLabel];
    }
}
