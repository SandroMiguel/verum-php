<?php

/**
 * Rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   2.1.0 (13/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Validator;

/**
 * Class Rule | src/Rules/Rule.php | Abstract class
 */
abstract class Rule implements RuleInterface
{
    /** @var mixed Field label */
    protected $fieldLabel;

    /** @var string Field name under test */
    protected $fieldNameUnderTest;

    /** @var mixed Field value */
    protected $fieldValue;

    /** @var array<mixed> Rule values */
    protected $ruleValues;

    /** @var Validator Validator object */
    protected $validator;

    /**
     * Setter ($fieldLabel)
     *
     * @param string $fieldLabel Field label.
     */
    public function setFieldLabel(?string $fieldLabel): void
    {
        $this->fieldLabel = $fieldLabel;
    }

    /**
     * Setter ($fieldNameUnderTest)
     *
     * @param string $fieldNameUnderTest Field name under test.
     */
    public function setFieldNameUnderTest(string $fieldNameUnderTest): void
    {
        $this->fieldNameUnderTest = $fieldNameUnderTest;
    }

    /**
     * Setter ($ruleValues)
     *
     * @param array<mixed> $ruleValues Rule values.
     */
    public function setRuleValues(array $ruleValues): void
    {
        $this->ruleValues = $ruleValues;
    }

    /**
     * Setter ($validator)
     *
     * @param Validator $validator Validator object.
     */
    public function setValidator(Validator $validator): void
    {
        $this->validator = $validator;
    }
}
