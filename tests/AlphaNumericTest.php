<?php

/**
 * AlphaNumericTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.0.0 (10/05/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use Verum\Rules\AlphaNumeric;
use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class AlphaNumericTest | tests/AlphaNumericTest.php | Test for AlphaNumeric
 */
class AlphaNumericTest extends TestCase
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
        $ruleName = 'alpha_numeric';
        $ruleValues = [];
        $validator = new Validator(
            [
                $fieldName => $fieldValue,
            ],
            [
                $fieldName => [
                    'label' => 'Some label',
                    'rules' => [$ruleName],
                ],
            ]
        );
        $rule = RuleFactory::loadRule($validator, $fieldValue, $ruleValues, $fieldName, $ruleName, '');

        return $rule->validate();
    }

    /**
     * The String ('some-text-123') value should not pass validation.
     *
     * @return void
     */
    public function testValidateSpecialChars(): void
    {
        $this->assertFalse($this->validate('some-text-123'));
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
     * The String ('hello123') value should pass validation.
     *
     * @return void
     */
    public function testValidateAlphaNumeric(): void
    {
        $this->assertTrue($this->validate('hello123'));
    }
}
