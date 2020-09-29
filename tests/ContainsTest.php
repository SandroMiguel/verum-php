<?php

/**
 * ContainsTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.1.2 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class ContainsTest | tests/ContainsTest.php | Test for Contains
 */
class ContainsTest extends TestCase
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
        $ruleName = 'contains';
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
     * If the Rule Values are not defined, an exception should be thrown.
     *
     * @return void
     */
    public function testValidateWithoutRuleValues(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage(
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "contains": the rule values are mandatory'
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
        $this->assertTrue($this->validate(null, ['HELLO', 'WORLD']));
    }

    /**
     * An Empty String ('') value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $this->assertTrue($this->validate('', ['HELLO', 'WORLD']));
    }

    /**
     * A Zero String ('0') value should not pass validation.
     *
     * @return void
     */
    public function testValidateZeroString(): void
    {
        $this->assertFalse($this->validate('0', ['HELLO', 'WORLD']));
    }

    /**
     * The Zero Number (0) value should not pass validation.
     *
     * @return void
     */
    public function testValidateZeroNumber(): void
    {
        $this->assertFalse($this->validate(0, ['HELLO', 'WORLD']));
    }

    /**
     * A Boolean (false) value should not pass validation.
     *
     * @return void
     */
    public function testValidateFalse(): void
    {
        $this->assertFalse($this->validate(false, ['HELLO', 'WORLD']));
    }

    /**
     * An Empty Array ([]) value should not pass validation.
     *
     * @return void
     */
    public function testValidateEmptyArray(): void
    {
        $this->assertFalse($this->validate([], ['HELLO', 'WORLD']));
    }

    /**
     * The Minus One (-1) value should not pass validation.
     *
     * @return void
     */
    public function testValidateMinusOne(): void
    {
        $this->assertFalse($this->validate(-1, ['HELLO', 'WORLD']));
    }

    /**
     * The One (1) value should not pass validation.
     *
     * @return void
     */
    public function testValidateOne(): void
    {
        $this->assertFalse($this->validate(1, ['HELLO', 'WORLD']));
    }

    /**
     * A Boolean (true) value should not pass validation.
     *
     * @return void
     */
    public function testValidateTrue(): void
    {
        $this->assertFalse($this->validate(true, ['HELLO', 'WORLD']));
    }

    /**
     * The String ('hello') value should not pass validation.
     *
     * @return void
     */
    public function testValidateHelloLowerCase(): void
    {
        $this->assertFalse($this->validate('hello', ['HELLO', 'WORLD']));
    }

    /**
     * The String ('HELLO') value should not pass validation.
     *
     * @return void
     */
    public function testValidateHelloUpperCase(): void
    {
        $this->assertTrue($this->validate('HELLO', ['HELLO', 'WORLD']));
    }
}
