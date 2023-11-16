<?php

/**
 * Min Length rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   3.0.0 (2020/09/21)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\ValidatorException;

/**
 * Class MinLength | src/Rules/MinLength.php | MinLength rule
 * Checks whether the number of characters of the value is not less than a given value.
 */
final class MinLength extends Rule
{
    /** @var int Min length value */
    private $minLength;

    /**
     * MinLength constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @throws ValidatorException Validator Exception.
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
     * @version 2.0.0 (2020/09/21)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "min_length": the rule value is mandatory'
            );
        }
        if (!is_int($this->ruleValues[0])) {
            throw ValidatorException::noIntegerValue($this->ruleValues[0]);
        }

        $this->minLength = $this->ruleValues[0];

        if ($this->fieldValue === null) {
            return true;
        }

        if (
            !isset($this->fieldValue)
            || is_array($this->fieldValue)
            || mb_strlen((string) $this->fieldValue) < $this->minLength
        ) {
            return false;
        }

        return true;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, mixed> Returns the parameters for the error message.
     *
     * @version 1.0.1 (2020/06/14)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->minLength, $this->fieldLabel];
    }
}
