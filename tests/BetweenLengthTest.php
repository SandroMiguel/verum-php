<?php

/**
 * BetweenLengthTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.0 (10/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class BetweenLengthTest | tests/BetweenLengthTest.php | Test for BetweenLength
 */
class BetweenLengthTest extends TestCase
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
        $ruleName = 'between_length';
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
        $rule = RuleFactory::loadRule(
            $validator,
            $fieldValue,
            $ruleValues,
            $fieldLabel,
            $ruleName,
            ''
        );
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
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "between_length": the rule values are mandatory'
        );
        $this->validate('some text', []);
    }

    /**
     * The String ('text with 23 characters') value should violate the rule with length between 50 and 100 characters.
     *
     * @return void
     */
    public function testValidateLessThanMin(): void
    {
        $this->assertFalse($this->validate('text with 23 characters', [50, 100]));
    }

    /**
     * The String ('text with 23 characters') value should violate the rule with length between 10 and 20 characters.
     *
     * @return void
     */
    public function testValidateGreatThanMax(): void
    {
        $this->assertFalse($this->validate('text with 23 characters', [10, 20]));
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
     * The String ('text with 23 characters') value should pass the rule with length between 10 and 23 characters.
     *
     * @return void
     */
    public function testValidateBetween(): void
    {
        $this->assertTrue($this->validate('text with 23 characters', [10, 23]));
    }
}
