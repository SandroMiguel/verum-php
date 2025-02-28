<?php

/**
 * MinLengthTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.0 (2020/06/25)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;
use Verum\ValidatorException;

/**
 * Class MinLengthTest | tests/MinLengthTest.php | Test for MinLength
 */
class MinLengthTest extends TestCase
{
    /**
     * Validates the field value against the rule.
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
        $ruleName = 'min_length';
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
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "min_length": the rule value is mandatory'
        );
        $this->validate(['some text'], []);
    }

    /**
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertTrue($this->validate(null, [5]));
    }

    /**
     * A numeric string, e.g. '10', should be accepted as rule value.
     */
    public function testValidateNumericString(): void
    {
        $this->assertFalse($this->validate('text with 23 characters', ['30']));
    }

    /**
     * The String ('text with 23 characters') value should violate the rule with min length of 30 characters.
     *
     * @return void
     */
    public function testValidateLongText(): void
    {
        $this->assertFalse($this->validate('text with 23 characters', [30]));
    }

    /**
     * The String ('text with 23 characters') value should pass the rule with min length of 20 characters.
     *
     * @return void
     */
    public function testPassValidateShortText(): void
    {
        $this->assertTrue($this->validate('text with 23 characters', [20]));
    }
}
