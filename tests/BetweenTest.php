<?php

/**
 * BetweenTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.2 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class BetweenTest | tests/BetweenTest.php | Test for Between
 */
class BetweenTest extends TestCase
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
        $ruleName = 'between';
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
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "between": the rule values are mandatory'
        );
        $this->validate('10', []);
    }

    /**
     * The String ('10') value should not pass validation with values between 20 and 30.
     *
     * @return void
     */
    public function testValidateLessThanMin(): void
    {
        $this->assertFalse($this->validate('10', [20, 30]));
    }

    /**
     * The String ('40') value should not pass validation with values between 20 and 30.
     *
     * @return void
     */
    public function testValidateGreaterThanMax(): void
    {
        $this->assertFalse($this->validate('40', [20, 30]));
    }

    /**
     * An Empty String ('') value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $this->assertTrue($this->validate('', [10, 20]));
    }

    /**
     * The String ('25') value should pass the rule with values between 20 and 30.
     *
     * @return void
     */
    public function testValidateBetween(): void
    {
        $this->assertTrue($this->validate('25', [20, 30]));
    }
}
