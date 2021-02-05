<?php

/**
 * Regex rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.0 (2020/10/31)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\ValidatorException;

/**
 * Class Regex | src/Rules/Regex.php
 * Checks whether the value matches a given regular expression.
 */
final class Regex extends Rule
{
    /** @var string Pattern value */
    private $pattern;

    /**
     * Regex constructor.
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
     * @version 2.0.0 (2020/10/31)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "regex": the rule value is mandatory'
            );
        }
        $this->pattern = $this->ruleValues[0];

        if ($this->fieldValue === null || $this->fieldValue === '') {
            return true;
        }

        try {
            if (!is_string($this->fieldValue)) {
                return false;
            }
            if (!preg_match($this->pattern, $this->fieldValue)) {
                return false;
            }
            return true;
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
     * @version 2.0.0 (2020/06/16)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->pattern, $this->fieldLabel];
    }
}
