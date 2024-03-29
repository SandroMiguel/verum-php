<?php

/**
 * DateTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.3.0 (2020/09/30)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class DateTest | tests/DateTest.php | Test for Date
 */
class DateTest extends TestCase
{
    /**
     * Validates the field value against the rule.
     *
     * @param mixed $fieldValue Field Value to validate.
     * @param array $ruleValues Rule values.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate($fieldValue, array $ruleValues = []): bool
    {
        $fieldName = 'some_field_name';
        $fieldLabel = 'Some Field Name';
        $ruleName = 'date';
        $validator = new Validator(
            [
                $fieldName => $fieldValue,
            ],
            [
                $fieldName => [
                    'label' => $fieldLabel,
                    'rules' => [$ruleName],
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
     * The Zero Number (0) value should not pass validation.
     *
     * @return void
     */
    public function testValidateZeroNumber(): void
    {
        $this->assertFalse($this->validate(0));
    }

    /**
     * The String ('hello') value should not pass validation.
     *
     * @return void
     */
    public function testValidateInvalidDate(): void
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
     * The String ('2020-05-19') value should pass validation.
     *
     * @return void
     */
    public function testValidateDefaultFormat(): void
    {
        $this->assertTrue($this->validate('2020-05-19'));
    }

    /**
     * The String ('19.05.2020') value should pass validation.
     *
     * @return void
     */
    public function testValidateCustomFormat(): void
    {
        $this->assertTrue($this->validate('19.05.2020', ['d.m.Y']));
    }

    /**
     * The String ('2020') value should pass validation.
     *
     * @return void
     */
    public function testValidateNumericStringCustomFormat(): void
    {
        $this->assertTrue($this->validate('2020', ['Y']));
    }

    /**
     * The Integer (2020) value should pass validation.
     *
     * @return void
     */
    public function testValidateNumberCustomFormat(): void
    {
        $this->assertTrue($this->validate(2020, ['Y']));
    }
}
