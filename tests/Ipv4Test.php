<?php

/**
 * Ipv4Test.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.0 (2020/10/21)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class Ipv4Test | tests/Ipv4Test.php | Test for Ipv4
 */
class Ipv4Test extends TestCase
{
    /**
     * Validates the field value against the rule.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     */
    private function validate($fieldValue): bool
    {
        $fieldName = 'some_field_name';
        $fieldLabel = 'Some Field Name';
        $ruleName = 'ipv4';
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
     * The String ('no ip') value should not pass validation.
     *
     * @return void
     */
    public function testValidateNoIp(): void
    {
        $this->assertFalse($this->validate('no ip'));
    }

    /**
     * The IPv6 ('2607:f0d0:1002:51::4') address should not pass validation.
     *
     * @return void
     */
    public function testValidateIpv6(): void
    {
        $this->assertFalse($this->validate('2607:f0d0:1002:51::4'));
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
     * The IPv4 ('10.10.10.10') address should pass validation.
     *
     * @return void
     */
    public function testValidateIpv4(): void
    {
        $this->assertTrue($this->validate('10.10.10.10'));
    }
}
