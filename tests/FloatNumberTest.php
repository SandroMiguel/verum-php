<?php

/**
 * FloatNumberTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.1.0 (28/05/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use Verum\Rules\FloatNumber;
use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class FloatNumberTest | tests/FloatNumberTest.php | Test for FloatNumber
 */
class FloatNumberTest extends TestCase
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
        $ruleName = 'float_number';
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
     * The String ('10') value should not pass validation.
     *
     * @return void
     */
    public function testValidateInteger(): void
    {
        $this->assertFalse($this->validate('10'));
    }

    /**
     * The String ('10,5') value should not pass validation.
     *
     * @return void
     */
    public function testValidateCommaSeparator(): void
    {
        $this->assertFalse($this->validate('10,5'));
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
     * The String ('10.0') value should pass validation.
     *
     * @return void
     */
    public function testValidateInsignificantZero(): void
    {
        $this->assertTrue($this->validate('10.0'));
    }

    /**
     * The String ('10.5') value should pass validation.
     *
     * @return void
     */
    public function testValidateFloat(): void
    {
        $this->assertTrue($this->validate('10.5'));
    }
}
