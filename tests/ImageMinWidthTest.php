<?php

/**
 * ImageMinWidthTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.1.2 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Rules\RuleFactory;
use Verum\Validator;
use Verum\ValidatorException;

/**
 * Class ImageMinWidthTest | tests/ImageMinWidthTest.php | Test for ImageMinWidth
 */
class ImageMinWidthTest extends TestCase
{

    /** @var array File mock (500x400) */
    private $fileMock = [
        'tmp_name' => __DIR__ . '/files/portugal-500x400.webp',
    ];

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
        $ruleName = 'image_min_width';
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
     * If the "Min Width" parameter is a (NULL) value, an exception should be thrown.
     *
     * @return void
     */
    public function testValidateInvalidMinWidth(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage(
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "image_min_width": the rule value is mandatory'
        );
        $this->validate([], []);
    }

    /**
     * An image where Width is (500) should not pass validation with min width = 1000.
     *
     * @return void
     */
    public function testValidateLessThanMin(): void
    {
        $this->assertFalse($this->validate($this->fileMock, [1000]));
    }

    /**
     * If there is no uploaded file, validation must pass.
     *
     * @return void
     */
    public function testValidateNoFile(): void
    {
        $this->assertTrue($this->validate([], [1000]));
    }

    /**
     * An image where Width is (500) should pass validation with max width = 100.
     *
     * @return void
     */
    public function testValidateGreaterThanMin(): void
    {
        $this->assertTrue($this->validate($this->fileMock, [100]));
    }
}
