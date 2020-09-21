<?php

/**
 * BetweenLengthTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.3.0 (2020/06/10)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class BetweenLengthTest | tests/BetweenLengthTest.php | Test for BetweenLength
 */
class BetweenLengthTest extends TestCase
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
        $ruleName = 'between_length';
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
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "between_length": the rule values are mandatory'
        );
        $this->validate('some text', []);
    }

    /**
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertTrue($this->validate(null, [10, 20]));
    }

    /**
     * An Empty String ('') value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $this->assertTrue($this->validate('', [10, 20]));
    }

    /**
     * A Zero String ('0') value should not pass validation.
     *
     * @return void
     */
    public function testValidateZeroString(): void
    {
        $this->assertFalse($this->validate('0', [10, 20]));
    }

    /**
     * The Zero Number (0) value should not pass validation.
     *
     * @return void
     */
    public function testValidateZeroNumber(): void
    {
        $this->assertFalse($this->validate(0, [10, 20]));
    }

    /**
     * A Boolean (false) value should not pass validation.
     *
     * @return void
     */
    public function testValidateFalse(): void
    {
        $this->assertFalse($this->validate(false, [10, 20]));
    }

    /**
     * An Empty Array ([]) value should not pass validation.
     *
     * @return void
     */
    public function testValidateEmptyArray(): void
    {
        $this->assertFalse($this->validate([], [10, 20]));
    }

    /**
     * The Minus One (-1) value should not pass validation.
     *
     * @return void
     */
    public function testValidateMinusOne(): void
    {
        $this->assertFalse($this->validate(-1, [10, 20]));
    }

    /**
     * The One (1) value should not pass validation.
     *
     * @return void
     */
    public function testValidateOne(): void
    {
        $this->assertFalse($this->validate(1, [10, 20]));
    }

    /**
     * The One (12345) value should not pass validation.
     *
     * @return void
     */
    public function testValidateFiveDigits(): void
    {
        $this->assertTrue($this->validate(12345, [5, 10]));
    }

    /**
     * A Boolean (true) value should not pass validation.
     *
     * @return void
     */
    public function testValidateTrue(): void
    {
        $this->assertFalse($this->validate(true, [10, 20]));
    }

    /**
     * The String ('text with 23 characters') value should violate the rule with length between 50 and 100 characters.
     *
     * @return void
     */
    public function testValidateLessThanMin(): void
    {
        $this->assertFalse(
            $this->validate('text with 23 characters', [50, 100])
        );
    }

    /**
     * The String ('text with 23 characters') value should violate the rule with length between 10 and 20 characters.
     *
     * @return void
     */
    public function testValidateGreatThanMax(): void
    {
        $this->assertFalse(
            $this->validate('text with 23 characters', [10, 20])
        );
    }

    /**
     * The String ('text with 23 characters') value should pass the rule with length between 10 and 23 characters.
     *
     * @return void
     */
    public function testValidateBetween(): void
    {
        $this->assertTrue($this->validate('text with 23 characters', [10, 23]));
    }
}
