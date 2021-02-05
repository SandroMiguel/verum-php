<?php

/**
 * RuleFactoryTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.0.1 (26/05/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use Verum\Exception\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Rules\RuleInterface;
use PHPUnit\Framework\TestCase;
use Verum\Validator;

/**
 * Class RuleFactoryTest | tests/RuleFactoryTest.php | Test for RuleFactory
 */
class RuleFactoryTest extends TestCase
{

    /** @var string Field name */
    protected $fieldName;

    /** @var array Field values */
    protected $fieldValues;

    /** @var array Field rules */
    protected $fieldRules;

    /**
     * Set up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->fieldName = 'field_name';
        $this->fieldValues = [$this->fieldName => ''];
        $this->fieldRules = [
            $this->fieldName => [
                'label' => 'Some label',
                'rules' => ['required'],
            ],
        ];
    }

    /**
     * The rule should be loaded.
     *
     * @return void
     */
    public function testCanLoadRule(): void
    {
        $validator = new Validator(
            $this->fieldValues,
            $this->fieldRules
        );
        $rule = RuleFactory::loadRule($validator, '', [], $this->fieldName, 'required', '');
        $this->assertInstanceOf(RuleInterface::class, $rule);
    }

    /**
     * An Exception should be raised because rule was not found.
     *
     * @return void
     */
    public function testExpectedExceptionIsRaised(): void
    {
        $validator = new Validator(
            $this->fieldValues,
            $this->fieldRules
        );
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('The "nonexistent-rule" rule was not found.');
        RuleFactory::loadRule($validator, '', [], $this->fieldName, 'nonexistent-rule', '');
    }
}
