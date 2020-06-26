<?php

/**
 * IpTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.1.1 (11/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class IpTest | tests/IpTest.php | Test for Ip
 */
class IpTest extends TestCase
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
        $ruleName = 'ip';
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
     * The String ('no ip') value should not pass validation.
     *
     * @return void
     */
    public function testValidateNoIp(): void
    {
        $this->assertFalse($this->validate('no ip'));
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

    /**
     * The IPv6 ('2607:f0d0:1002:51::4') address should pass validation.
     *
     * @return void
     */
    public function testValidateIpv6(): void
    {
        $this->assertTrue($this->validate('2607:f0d0:1002:51::4'));
    }
}
