<?php

/**
 * ImageMaxHeightTest.
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
use Verum\Exception\ValidatorException;
use Verum\Rules\RuleFactory;
use Verum\Validator;

/**
 * Class ImageMaxHeightTest | tests/ImageMaxHeightTest.php | Test for ImageMaxHeight
 */
class ImageMaxHeightTest extends TestCase
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
        $ruleName = 'image_max_height';
        $validator = new Validator(
            [
                $fieldName => 'some value',
            ],
            [
                $fieldName => [
                    'label' => $fieldLabel,
                    'rules' => [$ruleName => [600]],
                ],
            ]
        );
        $rule = RuleFactory::loadRule($validator, $fieldValue, $ruleValues, $fieldLabel, $ruleName, '');

        return $rule->validate();
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
     * If the "Max Height" parameter is a (NULL) value, an exception should be thrown.
     *
     * @return void
     */
    public function testValidateInvalidMaxHeight(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage(
            'Invalid argument; Argument name: $ruleValues; Argument value: null; Rule "image_max_height": the rule value is mandatory'
        );
        $this->validate([], []);
    }

    /**
     * An image where Height is (400) should not pass validation with max height = 100.
     *
     * @return void
     */
    public function testValidateGreaterThanMax(): void
    {
        $this->assertFalse($this->validate($this->fileMock, [100]));
    }

    /**
     * An image where Height is (400) should pass validation with max height = 1000.
     *
     * @return void
     */
    public function testValidateLessThanMax(): void
    {
        $this->assertTrue($this->validate($this->fileMock, [1000]));
    }
}
