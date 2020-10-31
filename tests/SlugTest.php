<?php

/**
 * SlugTest.
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
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class SlugTest | tests/SlugTest.php | Test for Slug
 */
class SlugTest extends TestCase
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
        $ruleName = 'slug';
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
     * Null value should pass validation (ignored field).
     *
     * @return void
     */
    public function testValidateNull(): void
    {
        $this->assertTrue($this->validate(null));
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
     * The String ('-hello-world') value should not pass validation.
     *
     * @return void
     */
    public function testValidateStartsWithHyphen(): void
    {
        $this->assertFalse($this->validate('-hello-world'));
    }

    /**
     * The String ('_hello-world') value should not pass validation.
     *
     * @return void
     */
    public function testValidateStartsWithUnderscore(): void
    {
        $this->assertFalse($this->validate('_hello-world'));
    }

    /**
     * The String ('hello-world-') value should not pass validation.
     *
     * @return void
     */
    public function testValidateEndsWithHyphen(): void
    {
        $this->assertFalse($this->validate('hello-world-'));
    }

    /**
     * The String ('hello-world_') value should not pass validation.
     *
     * @return void
     */
    public function testValidateEndsWithUnderscore(): void
    {
        $this->assertFalse($this->validate('hello-world_'));
    }

    /**
     * The String ('hello--world') value should not pass validation.
     *
     * @return void
     */
    public function testValidateDoubleHyphen(): void
    {
        $this->assertFalse($this->validate('hello--world'));
    }

    /**
     * The String ('hello__world') value should not pass validation.
     *
     * @return void
     */
    public function testValidateDoubleUnderscore(): void
    {
        $this->assertFalse($this->validate('hello__world'));
    }

    /**
     * The String ('hello-world_123') value should pass validation.
     *
     * @return void
     */
    public function testValidateHyphenAndUnderscore(): void
    {
        $this->assertTrue($this->validate('hello-world_123'));
    }
}
