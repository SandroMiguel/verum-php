<?php

/**
 * Date rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.1 (2020/09/30)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exceptions\ValidatorException;

/**
 * Class Date | src/Rules/Date.php
 * Checks whether the value is a valid date (Y-m-d) or a custom format.
 */
final class Date extends Rule
{
    private const DEFAULT_FORMAT = 'Y-m-d';

    /** @var string Date format */
    private $format;

    /**
     * Date constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
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
     * @version 2.1.2 (2020/09/30)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if ($this->fieldValue === null || $this->fieldValue === '') {
            return true;
        }

        $this->format = $this->ruleValues[0] ?? self::DEFAULT_FORMAT;

        if (is_array($this->fieldValue)) {
            return false;
        }

        $date = \DateTime::createFromFormat(
            $this->format,
            (string) $this->fieldValue
        );
        if (
            !$date
            || (string) $this->fieldValue !== date(
                $this->format,
                $date->getTimestamp()
            )
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
     * @version 2.0.0 (2020/06/16)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->format, $this->fieldLabel];
    }
}
