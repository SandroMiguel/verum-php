<?php

/**
 * EqualsTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.3.0 (2020/10/18)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;
use Verum\ValidatorException;

/**
 * Class EqualsTest | tests/EqualsTest.php | Test for Equals
 */
class EqualsTest extends TestCase
{
    /**
     * Validates the field value against the rule.
     *
     * @param mixed $fieldValueUnderTest Field value to validate.
     * @param array $ruleValues Rule values.
     * @param string $fieldName FieldName.
     * @param Validator $validator Validator object.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate($fieldValueUnderTest, array $ruleValues, string $fieldName, Validator $validator): bool
    {
        $rule = RuleFactory::loadRule($validator, $fieldValueUnderTest, $ruleValues, $fieldName, 'equals', '');
        return $rule->validate();
    }

    /**
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $validator = new Validator(
            [
                'some_field_name' => 'some value',
            ],
            [
                'some_field_name' => [
                    'label' => 'Some Field Name',
                    'rules' => ['equals' => 'some value'],
                ],
            ]
        );
        $this->assertTrue(
            $this->validate(null, ['field_name_a'], 'field_name_b', $validator)
        );
    }

    /**
     * An Empty String ('') value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $validator = new Validator(
            [
                'some_field_name' => 'some value',
            ],
            [
                'some_field_name' => [
                    'label' => 'Some Field Name',
                    'rules' => ['equals' => 'some value'],
                ],
            ]
        );
        $this->assertTrue(
            $this->validate('', ['field_name_a'], 'field_name_b', $validator)
        );
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
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "equals": the rule value is mandatory'
        );
        $validator = new Validator(
            [
                'some_field_name' => 'some value',
            ],
            [
                'some_field_name' => [
                    'label' => 'Some Field Name',
                    'rules' => ['equals' => null],
                ],
            ]
        );
        $this->validate(null, [], '', $validator);
    }

    /**
     * Should not pass validation because the values are not equals.
     *
     * @return void
     */
    public function testValidateNotEquals(): void
    {
        $fieldValueUnderTest = 'B';
        $fieldNameToCompare = 'field_name_a';
        $fieldNameUnderTest = 'field_name_b';
        $validator = new Validator(
            [
                $fieldNameToCompare => 'A',
                'field_name_b' => $fieldValueUnderTest,
            ],
            [
                $fieldNameToCompare => [
                    'label' => 'Field Name A',
                ],
                'field_name_b' => [
                    'label' => 'Field Name B',
                    'rules' => ['equals' => $fieldNameToCompare],
                ],
            ]
        );
        $this->assertFalse(
            $this->validate(
                $fieldValueUnderTest,
                [$fieldNameToCompare],
                $fieldNameUnderTest,
                $validator
            )
        );
    }

    /**
     * Should pass validation because the values are not equals.
     *
     * @return void
     */
    public function testValidateEquals(): void
    {
        $fieldValueUnderTest = 'A';
        $fieldNameToCompare = 'field_name_a';
        $fieldNameUnderTest = 'field_name_b';
        $validator = new Validator(
            [
                'field_name_a' => 'A',
                'field_name_b' => $fieldValueUnderTest,
            ],
            [
                'field_name_a' => [
                    'label' => 'Field Name A',
                ],
                'field_name_b' => [
                    'label' => 'Field Name B',
                    'rules' => ['equals' => $fieldNameToCompare],
                ],
            ]
        );
        $this->assertTrue(
            $this->validate(
                $fieldValueUnderTest,
                [$fieldNameToCompare],
                $fieldNameUnderTest,
                $validator
            )
        );
    }
}
