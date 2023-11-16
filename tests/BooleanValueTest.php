<?php

/**
 * BooleanValueTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.0.1 (11/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class BooleanValueTest | tests/BooleanValueTest.php | Test for BooleanValue
 */
class BooleanValueTest extends TestCase
{
    /**
     * Validates the field value against the rule.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate($fieldValue): bool
    {
        $fieldName = 'some_field_name';
        $ruleName = 'boolean_value';
        $ruleValues = [];
        $validator = new Validator(
            [
                $fieldName => $fieldValue,
            ],
            [
                $fieldName => [
                    'label' => 'Some label',
                    'rules' => [$ruleName],
                ],
            ]
        );
        $rule = RuleFactory::loadRule($validator, $fieldValue, $ruleValues, $fieldName, $ruleName, '');

        return $rule->validate();
    }

    /**
     * The Number (10) value should not pass validation.
     *
     * @return void
     */
    public function testValidateIntegerTen(): void
    {
        $this->assertFalse($this->validate(10));
    }

    /**
     * The String ('hello') value should not pass validation.
     *
     * @return void
     */
    public function testValidateStringHello(): void
    {
        $this->assertFalse($this->validate('hello'));
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
     * The Number (1) value should pass validation.
     *
     * @return void
     */
    public function testValidateNumberOne(): void
    {
        $this->assertTrue($this->validate(1));
    }

    /**
     * The String ('on') value should pass validation.
     *
     * @return void
     */
    public function testValidateStringOn(): void
    {
        $this->assertTrue($this->validate('on'));
    }

    /**
     * The String ('yes') value should pass validation.
     *
     * @return void
     */
    public function testValidateStringYes(): void
    {
        $this->assertTrue($this->validate('yes'));
    }

    /**
     * The Boolean (true) value should pass validation.
     *
     * @return void
     */
    public function testValidateBooleanTrue(): void
    {
        $this->assertTrue($this->validate(true));
    }
}
