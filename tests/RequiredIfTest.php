<?php

/**
 * RequiredIfTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.0.0 (20/08/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class RequiredIfTest | tests/RequiredIfTest.php | Test for RequiredIf
 */
class RequiredIfTest extends TestCase
{
    /**
     * Validate.
     *
     * @param mixed $fieldValue Field Value to validate.
     * @param mixed $fieldDependValue Field Value of the Dependent "if" Field.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate($fieldValue, $fieldDependValue): bool
    {
        $fieldName = 'some_field_name';
        $fieldLabel = 'Some Field Name';
        $fieldDependName = 'depend_field_name';
        $fieldDependLabel = 'Depend Field Name';
        $ruleName = 'requiredIf';
        $ruleValues = [ $fieldDependName ];
        $validator = new Validator(
            [
                $fieldName => $fieldValue,
                $fieldDependName => $fieldDependValue,
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
     * Value is not empty, DependValue is empty (null) -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependEmpty1(): void
    {
        $this->assertTrue($this->validate("val1", null));
    }

   /**
     * Value is not empty, DependValue is empty ("") -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependEmpty2(): void
    {
        $this->assertTrue($this->validate("val1", ""));
    }

   /**
     * Value is empty (null), DependValue is empty (null) -> should pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependEmpty1(): void
    {
        $this->assertTrue($this->validate(null, null));
    }

   /**
     * Value is empty (""), DependValue is empty ("") -> should pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependEmpty2(): void
    {
        $this->assertTrue($this->validate("", ""));
    }

   /**
     * Value is not empty ("val1"), DependValue is not empty ("val2") -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependNotEmpty1(): void
    {
        $this->assertTrue($this->validate("val1", "val2"));
    }

   /**
     * Value is not empty (true), DependValue is not empty ("val2") -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependNotEmpty2(): void
    {
        $this->assertTrue($this->validate(true, "val2"));
    }

   /**
     * Value is not empty (0), DependValue is not empty ("val2") -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependNotEmpty3(): void
    {
        $this->assertTrue($this->validate(0, "val2"));
    }

   /**
     * Value is not-empty-like empty array, DependValue is not empty ("val2") -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependNotEmpty4(): void
    {
        $this->assertTrue($this->validate([], "val2"));
    }

   /**
     * Value is empty (null), DependValue is not empty ("val2") -> should NOT pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependNotEmpty1(): void
    {
        $this->assertFalse($this->validate(null, "val2"));
    }

   /**
     * Value is empty (""), DependValue is not empty ("val2") -> should NOT pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependNotEmpty2(): void
    {
        $this->assertFalse($this->validate("", "val2"));
    }

   /**
     * Value is empty-like false, DependValue is not empty ("val2") -> should NOT pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependNotEmpty3(): void
    {
        $this->assertFalse($this->validate(false, "val2"));
    }

}
