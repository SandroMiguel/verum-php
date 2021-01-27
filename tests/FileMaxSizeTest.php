<?php

/**
 * FileMaxSizeTest.
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
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class FileMaxSizeTest | tests/FileMaxSizeTest.php | Test for FileMaxSize
 */
class FileMaxSizeTest extends TestCase
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
        $ruleName = 'file_max_size';
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
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertTrue($this->validate(null, [102400]));
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
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "file_max_size": the rule value is mandatory'
        );
        $this->validate(['size' => '102400'], []);
    }

    /**
     * The "Max Size" parameter with the String ('THIS_IS_AN_INVALID_SIZE') value, an exception should be thrown.
     *
     * @return void
     */
    public function testValidateInvalidMaxSize(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('The "max size" parameter should be an integer value.');
        $this->validate(['size' => '102400'], ['THIS_IS_AN_INVALID_SIZE']);
    }

    /**
     * The String ('200000') value should not pass validation with max file size = 102400.
     *
     * @return void
     */
    public function testValidateStringGreaterThanMax(): void
    {
        $this->assertFalse($this->validate(['size' => '200000'], [102400]));
    }

    /**
     * The Numeric (200000) value should not pass validation with max file size = 102400.
     *
     * @return void
     */
    public function testValidateNumberGreaterThanMax(): void
    {
        $this->assertFalse($this->validate(['size' => 200000], [102400]));
    }

    /**
     * If there is no uploaded file, validation must pass.
     *
     * @return void
     */
    public function testValidateNoFile(): void
    {
        $this->assertTrue($this->validate([], [102400]));
    }

    /**
     * The String ('50000') value should pass validation with max file size = 102400.
     *
     * @return void
     */
    public function testValidateNumberLessThanMax(): void
    {
        $this->assertTrue($this->validate(['size' => '50000'], [102400]));
    }
}
