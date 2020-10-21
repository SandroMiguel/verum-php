<?php

/**
 * MaxTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.4.0 (2020/10/22)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class MaxTest | tests/MaxTest.php | Test for Max
 */
class MaxTest extends TestCase
{
    /**
     * Validate.
     *
     * @param mixed $fieldValue Field Value to validate.
     * @param array $ruleValues Rule values.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate($fieldValue, array $ruleValues): bool
    {
        $fieldName = 'some_field_name';
        $fieldLabel = 'Some Field Name';
        $ruleName = 'max';
        $validator = new Validator(
            [
                $fieldName => $fieldValue,
            ],
            [
                $fieldName => [
                    'label' => $fieldLabel,
                    'rules' => [$ruleName => $ruleValues],
                ],
            ]
        );
        $rule = RuleFactory::loadRule($validator, $fieldValue, $ruleValues, $fieldLabel, $ruleName, '');

        return $rule->validate();
    }

    /**
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertTrue($this->validate(null, [10]));
    }

    /**
     * If the Rule Values are not defined, an exception should be thrown.
     *
     * @return void
     */
    public function testValidateWithoutRuleValues(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage(
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "max": the rule value is mandatory'
        );
        $this->validate([20], []);
    }

    /**
     * The String ('not numeric') value should not pass validation.
     *
     * @return void
     */
    public function testValidateNotNumeric(): void
    {
        $this->assertFalse($this->validate(['not numeric'], [10]));
    }

    /**
     * The String ('20') value should not pass validation with max value = 10.
     *
     * @return void
     */
    public function testValidateStringGreaterThanMax(): void
    {
        $this->assertFalse($this->validate('20', [10]));
    }

    /**
     * The Numeric (20) value should not pass validation with max value = 10.
     *
     * @return void
     */
    public function testValidateNumberGreaterThanMax(): void
    {
        $this->assertFalse($this->validate(20, [10]));
    }

    /**
     * An Empty String ('') value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $this->assertTrue($this->validate('', [-1]));
    }

    /**
     * The Numeric (10) value should pass validation with max value = 20.
     *
     * @return void
     */
    public function testValidateNumberLessThanMax(): void
    {
        $this->assertTrue($this->validate(10, [20]));
    }
}
