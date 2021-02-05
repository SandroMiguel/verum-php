<?php

/**
 * AlphaNumeric rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   3.0.0 (2020/09/17)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

/**
 * Class AlphaNumeric | src/Rules/AlphaNumeric.php
 * Checks whether the value contains only alphanumeric characters.
 */
final class AlphaNumeric extends Rule
{
    /**
     * AlphaNumeric constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 1.0.0 (2020/05/10)
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
     * @version 3.0.0 (2020/09/17)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (
            $this->fieldValue === null
            || $this->fieldValue === ''
            || $this->fieldValue === 0
            || $this->fieldValue === 1
        ) {
            return true;
        }

        return ctype_alnum($this->fieldValue);
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
