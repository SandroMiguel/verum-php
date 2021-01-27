<?php

/**
 * AlphaTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.3.2 (2020/09/16)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class AlphaTest | tests/AlphaTest.php | Test for Alpha
 */
class AlphaTest extends TestCase
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
        $ruleName = 'alpha';
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
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertTrue($this->validate(null));
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
        $this->assertFalse($this->validate(0));
    }

    /**
     * The String ('hello') value should pass validation.
     *
     * @return void
     */
    public function testValidateAlphabetic(): void
    {
        $this->assertTrue($this->validate('hello'));
    }

    /**
     * The String ('text with spaces') value should not pass validation.
     *
     * @return void
     */
    public function testValidateAlphabeticWithSpaces(): void
    {
        $this->assertFalse($this->validate('text with spaces'));
    }

    /**
     * The String ('some text 123') value should not pass validation.
     *
     * @return void
     */
    public function testValidateAlphaNumeric(): void
    {
        $this->assertFalse($this->validate('some text 123'));
    }
}
