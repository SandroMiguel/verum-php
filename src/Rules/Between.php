<?php

/**
 * Between rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.2 (2021/01/23)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exceptions\ValidatorException;

/**
 * Class Between | src/Rules/Between.php
 * Checks whether the value is between two values.
 */
final class Between extends Rule
{
    /** @var int Min value */
    private $minValue;

    /** @var int Max value */
    private $maxValue;

    /**
     * Between constructor.
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
     * @version 2.0.4 (2021/01/23)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'The values min and max are mandatory on rule "between"'
            );
        }
        if (!isset($this->ruleValues[1])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[1] ?? 'null',
                'The values min and max are mandatory on rule "between"'
            );
        }
        $this->minValue = $this->ruleValues[0];
        $this->maxValue = $this->ruleValues[1];

        if ($this->fieldValue === '') {
            return true;
        }

        $min = new Min($this->fieldValue);
        $min->setRuleValues([$this->minValue]);
        $max = new Max($this->fieldValue);
        $max->setRuleValues([$this->maxValue]);

        if (!$min->validate() || !$max->validate()) {
            return false;
        }

        return true;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, mixed> Returns the parameters for the error message.
     *
     * @version 2.0.1 (2021/01/23)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->minValue, $this->maxValue, $this->fieldLabel];
    }
}
