<?php

/**
 * RequiredTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   2.0.0 (2020/09/16)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class RequiredTest | tests/RequiredTest.php | Test for Required
 */
class RequiredTest extends TestCase
{
    /**
     * Validate.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate($fieldValue): bool
    {
        $fieldName = 'some_field_name';
        $fieldLabel = 'Some Field Name';
        $ruleName = 'required';
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
     * A Null (null) value should not pass validation.
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertFalse($this->validate(null));
    }

    /**
     * An Empty String ('') value should not pass validation.
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $this->assertFalse($this->validate(''));
    }

    /**
     * A Zero String ("0") value should pass validation.
     *
     * @return void
     */
    public function testValidateZeroString(): void
    {
        $this->assertTrue($this->validate('0'));
    }

    /**
     * A Zero (0) value should pass validation.
     *
     * @return void
     */
    public function testValidateZero(): void
    {
        $this->assertTrue($this->validate(0));
    }

    /**
     * A Boolean (false) value should pass validation.
     *
     * @return void
     */
    public function testValidateFalse(): void
    {
        $this->assertTrue($this->validate(false));
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
     * An Array (['something']) value should pass validation.
     *
     * @return void
     */
    public function testValidateArray(): void
    {
        $this->assertTrue($this->validate(['reg', 'green', 'blue']));
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
     * The One (1) value should pass validation.
     *
     * @return void
     */
    public function testValidateOne(): void
    {
        $this->assertTrue($this->validate(1));
    }

    /**
     * A String ('some text') value should pass validation.
     *
     * @return void
     */
    public function testPassValidateText(): void
    {
        $this->assertTrue($this->validate('some text'));
    }
}
