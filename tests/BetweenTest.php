<?php

/**
 * BetweenTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.3.0 (2020/09/19)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class BetweenTest | tests/BetweenTest.php | Test for Between
 */
class BetweenTest extends TestCase
{
    /**
     * Validates the field value against the rule.
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
        $ruleName = 'between';
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
        $rule = RuleFactory::loadRule(
            $validator,
            $fieldValue,
            $ruleValues,
            $fieldLabel,
            $ruleName,
            ''
        );

        return $rule->validate();
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
            'Invalid argument; Argument name: $ruleValues; Argument value: null; The values min and max are mandatory on rule "between"'
        );
        $this->validate('10', []);
    }

    /**
     * If the rule has only the first value defined, an exception must be thrown.
     *
     * @return void
     */
    public function testValidateWithOneRuleValue(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage(
            'Invalid argument; Argument name: $ruleValues; Argument value: null; The values min and max are mandatory on rule "between"'
        );
        $this->validate('10', [1]);
    }

    /**
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertTrue($this->validate(null, [1, 10]));
    }

    /**
     * An Empty String ('') value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $this->assertTrue($this->validate('', [1, 10]));
    }

    /**
     * The String ('10') value should not pass validation with values between 20 and 30.
     *
     * @return void
     */
    public function testValidateLessThanMin(): void
    {
        $this->assertFalse($this->validate('10', [20, 30]));
    }

    /**
     * The String ('40') value should not pass validation with values between 20 and 30.
     *
     * @return void
     */
    public function testValidateGreaterThanMax(): void
    {
        $this->assertFalse($this->validate('40', [20, 30]));
    }

    /**
     * The String ('25') value should pass the rule with values between 20 and 30.
     *
     * @return void
     */
    public function testValidateBetween(): void
    {
        $this->assertTrue($this->validate('25', [20, 30]));
    }

    /**
     * A Zero String ('0') value should not pass validation.
     *
     * @return void
     */
    public function testValidateZeroString(): void
    {
        $this->assertFalse($this->validate('0', [1, 10]));
    }

    /**
     * The Zero Number (0) value should not pass validation.
     *
     * @return void
     */
    public function testValidateZeroNumber(): void
    {
        $this->assertFalse($this->validate(0, [1, 10]));
    }

    /**
     * A Boolean (false) value should not pass validation.
     *
     * @return void
     */
    public function testValidateFalse(): void
    {
        $this->assertFalse($this->validate(false, [1, 10]));
    }

    /**
     * An Empty Array ([]) value should not pass validation.
     *
     * @return void
     */
    public function testValidateEmptyArray(): void
    {
        $this->assertFalse($this->validate([], [1, 10]));
    }

    /**
     * The Minus One (-1) value should not pass validation.
     *
     * @return void
     */
    public function testValidateMinusOne(): void
    {
        $this->assertFalse($this->validate(-1, [1, 10]));
    }

    /**
     * The One (1) value should pass validation.
     *
     * @return void
     */
    public function testValidateOne(): void
    {
        $this->assertTrue($this->validate(1, [1, 10]));
    }

    /**
     * A Boolean (true) value should not pass validation.
     *
     * @return void
     */
    public function testValidateTrue(): void
    {
        $this->assertFalse($this->validate(true, [1, 10]));
    }

    /**
     * The String ('some text') value should not pass validation.
     *
     * @return void
     */
    public function testValidateAlphaNumeric(): void
    {
        $this->assertFalse($this->validate('some text', [1, 10]));
    }
}
