<?php

/**
 * IntegerTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package Verum-PHP
 * @license MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2022 Sandro
 * @since Verum-PHP 2.1.0
 * @version 1.0.0 (2022/07/13)
 * @link https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class IntegerTest | tests/IntegerTest.php | Test for Integer
 */
class IntegerTest extends TestCase
{
    /**
     * Validates the field value against the rule.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate(mixed $fieldValue): bool
    {
        $fieldName = 'some_field_name';
        $fieldLabel = 'Some Field Name';
        $ruleName = 'integer';
        $ruleValues = [];
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
        $this->assertTrue($this->validate(null));
    }

    /**
     * The String ('some text') value should not pass validation.
     *
     * @return void
     */
    public function testValidateString(): void
    {
        $this->assertFalse($this->validate('some text'));
    }

    /**
     * An Empty String ('') value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $this->assertTrue($this->validate(''));
    }

    /**
     * A Zero String ('0') value should not pass validation.
     *
     * @return void
     */
    public function testValidateZeroString(): void
    {
        $this->assertFalse($this->validate('0'));
    }

    /**
     * The Zero Number (0) value should pass validation.
     *
     * @return void
     */
    public function testValidateZeroNumber(): void
    {
        $this->assertTrue($this->validate(0));
    }

    /**
     * A Boolean (false) value should not pass validation.
     *
     * @return void
     */
    public function testValidateFalse(): void
    {
        $this->assertFalse($this->validate(false));
    }

    /**
     * An Empty Array ([]) value should not pass validation.
     *
     * @return void
     */
    public function testValidateEmptyArray(): void
    {
        $this->assertFalse($this->validate([]));
    }

    /**
     * The Minus One (-1) value should pass validation.
     *
     * @return void
     */
    public function testValidateMinusOne(): void
    {
        $this->assertTrue($this->validate(-1));
    }

    /**
     * The String ('1') value should not pass validation.
     *
     * @return void
     */
    public function testValidateStringNumber(): void
    {
        $this->assertFalse($this->validate('1'));
    }

    /**
     * The Numeric (1) value should pass validation.
     *
     * @return void
     */
    public function testValidateNumber(): void
    {
        $this->assertTrue($this->validate(1));
    }

    /**
     * A Boolean (true) value should not pass validation.
     *
     * @return void
     */
    public function testValidateTrue(): void
    {
        $this->assertFalse($this->validate(true));
    }

    /**
     * The String ('some-text-123') value should not pass validation.
     *
     * @return void
     */
    public function testValidateSpecialChars(): void
    {
        $this->assertFalse($this->validate('some-text-123'));
    }
}
