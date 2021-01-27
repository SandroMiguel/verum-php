<?php

/**
 * RegexTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.0 (2020/10/31)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class RegexTest | tests/RegexTest.php | Test for Regex
 */
class RegexTest extends TestCase
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
        $ruleName = 'regex';
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
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "regex": the rule value is mandatory'
        );
        $this->validate(['some input string'], []);
    }

    /**
     * The String ('/no-ending-delimiter') value should throw an exception.
     *
     * @return void
     */
    public function testValidateNoEndingDelimiter(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage(
            "Invalid argument; Argument name: pattern; Argument value: /no-ending-delimiter; preg_match(): No ending delimiter '/' found"
        );
        $this->validate('some input string', ['/no-ending-delimiter']);
    }

    /**
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertTrue($this->validate(null, ['/hello/']));
    }

    /**
     * An Empty String ('') value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateEmptyString(): void
    {
        $this->assertTrue($this->validate('', ['/hello/']));
    }

    /**
     * The String ('/hello/') value should not pass validation.
     *
     * @return void
     */
    public function testValidatePatternNotFound(): void
    {
        $this->assertFalse($this->validate('some input string', ['/hello/']));
    }

    /**
     * The String ('/hello/') value should pass validation.
     *
     * @return void
     */
    public function testValidateNumberLessThanMax(): void
    {
        $this->assertTrue($this->validate('hello world', ['/hello/']));
    }
}
