<?php

/**
 * Slug rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   3.0.0 (2020/10/31)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exception\ValidatorException;

/**
 * Class Slug | src/Rules/Slug.php
 * Checks whether the value is a valid Slug (e.g. hello-world_123).
 */
final class Slug extends Rule
{
    /**
     * Slug constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 1.0.0 (2020/05/17)
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
     * @version 3.0.0 (2020/10/31)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if ($this->fieldValue === null || $this->fieldValue === '') {
            return true;
        }

        try {
            if (!is_string($this->fieldValue)) {
                return false;
            }
            return preg_match(
                '/^[a-z0-9]+(-?[a-z0-9])*(_?[a-z0-9])*[a-z0-9]$/',
                $this->fieldValue
            ) !== 0;
        } catch (\Exception $ex) {
            throw ValidatorException::invalidArgument(
                'pattern',
                $this->pattern,
                null,
                0,
                $ex
            );
        }
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 1.0.1 (2020/06/14)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->fieldLabel];
    }
}
