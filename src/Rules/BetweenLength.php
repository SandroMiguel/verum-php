<?php

/**
 * BetweenLength rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.1 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exception\ValidatorException;

/**
 * Class BetweenLength | src/Rules/BetweenLength.php
 * Checks whether the number of characters of the value is between min and max values.
 */
final class BetweenLength extends Rule
{
    /** @var int Min length value */
    private $minLength;

    /** @var int Max length value */
    private $maxLength;

    /**
     * BetweenLength constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.0.0 (10/06/2020)
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
     * @version 2.1.3 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "between_length": the rule values are mandatory'
            );
        }
        if (!isset($this->ruleValues[1])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[1],
                'Rule "between_length": the rule values are mandatory'
            );
        }
        $this->minLength = $this->ruleValues[0];
        $this->maxLength = $this->ruleValues[1];

        if ($this->fieldValue === '') {
            return true;
        }

        $minLength = new MinLength($this->fieldValue);
        $minLength->setRuleValues([$this->minLength]);
        $maxLength = new MaxLength($this->fieldValue);
        $maxLength->setRuleValues([$this->maxLength]);

        if (!$minLength->validate() || !$maxLength->validate()) {
            return false;
        }

        return true;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, mixed> Returns the parameters for the error message.
     *
     * @version 2.0.0 (16/06/2020)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->minLength, $this->maxLength, $this->fieldLabel];
    }
}
