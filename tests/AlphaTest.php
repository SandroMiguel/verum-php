<?php

/**
 * AlphaTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.2 (11/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use Verum\Rules\Alpha;
use PHPUnit\Framework\TestCase;
use Verum\Exceptions\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class AlphaTest | tests/AlphaTest.php | Test for Alpha
 */
class AlphaTest extends TestCase
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
        $ruleName = 'alpha';
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
     * The String ('some text 123') value should not pass validation.
     *
     * @return void
     */
    public function testValidateAlphaNumeric(): void
    {
        $this->assertFalse($this->validate('some text 123'));
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
     * The String ('hello') value should pass validation.
     *
     * @return void
     */
    public function testValidateAlphabetic(): void
    {
        $this->assertTrue($this->validate('hello'));
    }
}
