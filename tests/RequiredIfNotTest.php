<?php

/**
 * RequiredIfNotTest.
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
 * Class RequiredIfNotTest | tests/RequiredIfNotTest.php | Test for RequiredIfNot
 */
class RequiredIfNotTest extends TestCase
{
    /**
     * Validates the field value against the rule.
     *
     * @param mixed $fieldValue Field Value to validate.
     * @param mixed $fieldDependValue Field Value of the Dependent "if not" Field.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate($fieldValue, $fieldDependValue): bool
    {
        $fieldName = 'some_field_name';
        $fieldLabel = 'Some Field Name';
        $fieldDependName = 'depend_field_name';
        $ruleName = 'requiredIfNot';
        $ruleValues = [$fieldDependName];
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
     * Value is not empty ("val1"), DependValue is empty (null) -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependEmpty1(): void
    {
        $this->assertTrue($this->validate("val1", null));
    }

    /**
     * Value is not empty ("val1"), DependValue is empty ("") -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependEmpty2(): void
    {
        $this->assertTrue($this->validate("val1", ""));
    }

    /**
     * Value is not empty (0), DependValue is empty (null) -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependEmpty3(): void
    {
        $this->assertTrue($this->validate(0, null));
    }

    /**
     * Value is empty (null), DependValue is empty (null) -> should NOT pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependEmpty1(): void
    {
        $this->assertFalse($this->validate(null, null));
    }

    /**
     * Value is empty (""), DependValue is empty ("") -> should NOT pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependEmpty2(): void
    {
        $this->assertFalse($this->validate("", ""));
    }

    /**
     * Value is empty (null), DependValue is empty-like false -> should NOT pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependEmpty3(): void
    {
        $this->assertFalse($this->validate(null, false));
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
     * Value is not empty ("val1"), DependValue is not empty (true) -> should pass the validation
     *
     * @return void
     */
    public function testValidateNotEmptyDependNotEmpty2(): void
    {
        $this->assertTrue($this->validate("val1", true));
    }

    /**
     * Value is empty (null), DependValue is not empty ("val2") -> should pass the validation
     *
     * @return void
     */
    public function testValidateEmptyDependNotEmpty1(): void
    {
        $this->assertTrue($this->validate(null, "val2"));
    }
}
