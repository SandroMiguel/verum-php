<?php

/**
 * ValidatorTest.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.3.0 (2021/01/27)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Tests;

use PHPUnit\Framework\TestCase;
use Verum\Enum\LangEnum;
use Verum\Enum\RuleEnum;
use Verum\Validator;
use Verum\ValidatorException;

/**
 * Class ValidatorTest | tests/ValidatorTest.php | Test for Validator
 */
class ValidatorTest extends TestCase
{

    /** @var array One field value OK */
    private $someField = ['some_field' => 'some value'];

    /** @var array Two fields value OK */
    private $twoFields = [
        'some_field_a' => '',
        'some_field_b' => 'some value B',
    ];

    /** @var array One field value OK */
    private $oneFieldValue = ['name' => 'John'];

    /** @var array One field value with empty string */
    private $oneFieldValueEmptyString = ['name' => ''];

    /** @var array Field without label */
    private $nameFieldWithoutLabelRequiredRule = [
        'name' => [
            'rules' => [RuleEnum::REQUIRED],
        ],
    ];

    /** @var array Field without label */
    private $nameFieldWithoutLabelNumericAndMinLengthRules = [
        'name' => [
            'rules' => [
                RuleEnum::NUMERIC,
                RuleEnum::MIN_LENGTH => 5
            ],
        ],
    ];

    /** @var array Field with "non_existent" rule */
    private $nameFieldNonExistentRule = [
        'name' => [
            'label' => 'Name',
            'rules' => ['non_existent'],
        ],
    ];

    /** @var array Field with "required" rule */
    private $nameFieldRequiredRule = [
        'name' => [
            'label' => 'Name',
            'rules' => [RuleEnum::REQUIRED],
        ],
    ];

    /** @var array Fields with "required" rule */
    private $someFieldsRequiredRule = [
        'some_field_a' => [
            'label' => 'Some field A',
            'rules' => [RuleEnum::REQUIRED],
        ],
        'some_field_b' => [
            'label' => 'Some field B',
            'rules' => [RuleEnum::REQUIRED],
        ],
    ];

    /** @var array Field with multiple labels and the "required" rule */
    private $nameFieldMultipleLabelsRequiredRule = [
        'name' => [
            'label' => [
                'en' => 'Name',
                'pt-pt' => 'Nome',
            ],
            'rules' => [RuleEnum::REQUIRED],
        ],
    ];

    /** @var array Field with multiple labels and the "min_length" rule */
    private $nameFieldMultipleLabelsMinLengthRule = [
        'name' => [
            'label' => [
                'en' => 'Name',
                'pt-pt' => 'Nome',
            ],
            'rules' => [RuleEnum::MIN_LENGTH => 5],
        ],
    ];

    /** @var array Field with "min_length" rule */
    private $nameFieldMinLengthRule = [
        'name' => [
            'label' => 'Name',
            'rules' => [
                RuleEnum::MIN_LENGTH => 5,
            ],
        ],
    ];

    /** @var array Field with "required" and "min_length" rules */
    private $nameFieldRequiredAndMinLengthRules = [
        'name' => [
            'label' => 'Name',
            'rules' => [
                RuleEnum::REQUIRED,
                RuleEnum::MIN_LENGTH => 5,
            ],
        ],
    ];

    /** @var array Field with "file_max_size" rule */
    private $nameFieldFileMaxSizeRule = [
        'upload_file' => [
            'label' => 'Profile photo',
            'rules' => [RuleEnum::FILE_MAX_SIZE => [102400]],
        ],
    ];

    /** @var array Custom error messages */
    private $customErrorMessages = [
        'numeric' => [
            'withLabel' => 'Custom message with label for "numeric" rule. Label: {param:1}.',
            'withoutLabel' => 'Custom message without label for "numeric" rule.',
        ],
        'min_length' => [
            'withLabel' => 'Custom message with label for "min_length" rule. Label: {param:2}, value: {param:1}.',
            'withoutLabel' => 'Custom message without label for "min_length" rule. Value: {param:1}.',
        ],
    ];

    /**
     * Without fields to process - An exception should be thrown.
     *
     * @return void
     */
    public function testValidateWithoutFields(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('There is no fields to process.');
        $noFields = [];
        $validator = new Validator(
            $noFields,
            $this->nameFieldNonExistentRule,
            debugMode: true
        );
        $validator->validate();
    }

    /**
     * Try to use a rule that doesn't exist - An exception should be thrown.
     *
     * @return void
     */
    public function testValidateNonExistentRule(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('The "non_existent" rule was not found.');
        $validator = new Validator($this->oneFieldValueEmptyString, $this->nameFieldNonExistentRule, debugMode: true);
        $validator->validate();
    }

    /**
     * Try to use a language that doesn't exist - An exception should be thrown.
     *
     * @return void
     */
    public function testGetErrorsNonExistentLanguage(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage(
            'Invalid argument; Argument name: $lang; Argument value: zz-ZZ; Language not available'
        );
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldRequiredRule,
            'zz-ZZ',
            true
        );
        $validator->validate();
    }

    /**
     * Error message with wrong number of placeholders - An exception should be thrown.
     *
     * @return void
     */
    public function testGetErrorsMessageWrongPlaceholders(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage(
            'The arguments array must contain 3 items, 2 given; Message: Message "min_length" rule. val1 = {param:1}, val2 = {param:2}, val3 = {param:3}.; Arguments: 5,Name'
        );
        $validator = new Validator($this->oneFieldValue, $this->nameFieldMinLengthRule, debugMode: true);
        $validator->addSimpleCustomMessage(
            'min_length',
            'Message "min_length" rule. val1 = {param:1}, val2 = {param:2}, val3 = {param:3}.'
        );
        $validator->validate();
    }

    /**
     * Should detect rule violation.
     *
     * @return void
     */
    public function testValidateRuleViolation(): void
    {
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldRequiredRule,
            debugMode: true
        );
        $isValid = $validator->validate();
        $this->assertFalse($isValid);
    }

    /**
     * Asserts the error message (default language).
     *
     * @return void
     */
    public function testGetErrorsDefaultLanguage(): void
    {
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'required' => 'The "Name" field is required.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldRequiredRule,
            debugMode: true
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts the error message (without label) - should be displayed a message without the label.
     *
     * @return void
     */
    public function testGetErrorsWithoutLabel(): void
    {
        $expected = [
            'name' => [
                'rules' => [
                    'required' => 'This field is required.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldWithoutLabelRequiredRule,
            debugMode: true
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts the error message (with label) - should be displayed a message with the label.
     *
     * @return void
     */
    public function testGetErrorsWithLabel(): void
    {
        $expected = [
            'name' => [
                'rules' => [
                    'required' => 'The "Name" field is required.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldRequiredRule,
            debugMode: true
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts the error message (with multiple translated labels).
     * A message should be displayed with the label in a specific language.
     *
     * @return void
     */
    public function testGetErrorsWithMultipleLabels(): void
    {
        $expected = [
            'name' => [
                'rules' => [
                    'required' => 'The "Name" field is required.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldMultipleLabelsRequiredRule,
            debugMode: true
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts the error message (pt-pt language).
     *
     * @return void
     */
    public function testGetErrorsNonDefaultLanguage(): void
    {
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'required' => 'O campo "Name" é obrigatório.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldRequiredRule,
            LangEnum::PT_PT,
            true
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts a simple custom error message.
     *
     * @return void
     */
    public function testGetErrorsCustomMessage(): void
    {
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'required' => 'Custom message for the "required" rule.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldRequiredRule,
            LangEnum::PT_PT,
            true
        );
        $validator->addSimpleCustomMessage('required', 'Custom message for the "required" rule.');
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts custom error message for fields without label.
     *
     * @return void
     */
    public function testGetErrorsCustomMessageWithoutLabel(): void
    {
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'required' => 'Custom message without label for required rule.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldWithoutLabelRequiredRule,
            LangEnum::PT_PT,
            true
        );
        $validator->addCustomMessage(
            'required',
            'Custom message with label for required rule. Label: {param:1}.',
            'Custom message without label for required rule.'
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts custom error message for fields with label.
     *
     * @return void
     */
    public function testGetErrorsCustomMessageWithLabel(): void
    {
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'required' => 'Custom message with label for required rule. Label: Name.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldRequiredRule,
            debugMode: true
        );
        $validator->addCustomMessage(
            'required',
            'Custom message with label for required rule. Label: {param:1}.',
            'Custom message without label for required rule.'
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts custom error message for fields with label.
     *
     * @return void
     */
    public function testGetErrorsCustomMessageWithMultipleLabels(): void
    {
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'required' => 'Custom message with label for required rule. Label: Nome.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldMultipleLabelsRequiredRule,
            LangEnum::PT_PT,
            true
        );
        $validator->addCustomMessage(
            'required',
            'Custom message with label for required rule. Label: {param:1}.',
            'Custom message without label for required rule.'
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts custom error messages - field with label - language independent.
     *
     * @return void
     */
    public function testGetErrorsCustomMessages(): void
    {
        $customErrorMessages = [
            'min_length' => 'Custom message for the "min_length" rule.',
            'required' => 'Custom message for the "required" rule.',
        ];
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'required' => 'Custom message for the "required" rule.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValueEmptyString,
            $this->nameFieldRequiredAndMinLengthRules,
            LangEnum::PT_PT,
            true
        );
        $validator->addCustomMessages($customErrorMessages);
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts custom error messages for fields without label.
     *
     * @return void
     */
    public function testGetErrorsCustomMessagesWithoutLabel(): void
    {
        $expected = [
            'name' => [
                'label' => null,
                'rules' => [
                    'numeric' => 'Custom message without label for "numeric" rule.',
                    'min_length' => 'Custom message without label for "min_length" rule. Value: 5.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValue,
            $this->nameFieldWithoutLabelNumericAndMinLengthRules,
            debugMode: true
        );
        $validator->addCustomMessages($this->customErrorMessages);
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts custom error messages for fields with multi-language labels.
     *
     * @return void
     */
    public function testGetErrorsCustomMessagesWithLabel(): void
    {
        $expected = [
            'name' => [
                'label' => [
                    'en' => 'Name',
                    'pt-pt' => 'Nome',
                ],
                'rules' => [
                    'min_length' => 'Custom message with label for "min_length" rule. Label: Nome, value: 5.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValue,
            $this->nameFieldMultipleLabelsMinLengthRule,
            LangEnum::PT_PT,
            true
        );
        $validator->addCustomMessages($this->customErrorMessages);
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Asserts error message with placeholders.
     *
     * @return void
     */
    public function testGetErrorsMessagePlaceholders(): void
    {
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'min_length' => 'The "Name" field must be at least 5 characters long.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValue,
            $this->nameFieldMinLengthRule,
            debugMode: true
        );
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Error message that ignores placeholders.
     * The custom error message has no placeholders, e.g. {param:1}, so they aren't displayed.
     *
     * @return void
     */
    public function testGetErrorsMessageIgnoresPlaceholders(): void
    {
        $expected = [
            'name' => [
                'label' => 'Name',
                'rules' => [
                    'min_length' => 'Custom message for the "min_length" rule.',
                ],
            ],
        ];
        $validator = new Validator(
            $this->oneFieldValue,
            $this->nameFieldMinLengthRule,
            debugMode: true
        );
        $validator->addSimpleCustomMessage('min_length', 'Custom message for the "min_length" rule.');
        $validator->validate();
        $errors = $validator->getErrors();
        $this->assertTrue(
            empty(array_diff_assoc($expected['name']['rules'], $errors['name']['rules']))
        );
    }

    /**
     * Should ignore a nonexistent field. Should pass the validation.
     *
     * @return void
     */
    public function testValidateNonexistentField(): void
    {
        $validator = new Validator(
            $this->someField,
            $this->nameFieldFileMaxSizeRule,
            debugMode: true
        );
        $isValid = $validator->validate();
        $this->assertTrue($isValid);
    }

    /**
     * ?
     *
     * @return void
     */
    public function testValidateTwoFields(): void
    {
        $validator = new Validator(
            $this->twoFields,
            $this->someFieldsRequiredRule,
            debugMode: true
        );
        $isValid = $validator->validate();
        $this->assertFalse($isValid);
    }

    /**
     * Should not detect rule violation.
     *
     * @return void
     */
    public function testValidateNoRuleViolation(): void
    {
        $validator = new Validator(
            $this->oneFieldValue,
            $this->nameFieldRequiredRule,
            debugMode: true
        );
        $isValid = $validator->validate();
        $this->assertTrue($isValid);
    }

    /**
     * Tests the validation of multilingual fields with explicit field name
     *  along with language.
     */
    public function testValidateMultilangFields(): void
    {
        $fieldValues = [
            'title.en' => 'Engineer',
            'title.pt' => 'Engenheiro',
        ];

        $fieldRules = [
            'title.en' => [
                'label' => 'Title in English',
                'rules' => [RuleEnum::REQUIRED],
            ],
            'title.pt' => [
                'label' => 'Título em Português',
                'rules' => [RuleEnum::REQUIRED],
            ],
        ];

        $validator = new Validator($fieldValues, $fieldRules, debugMode: true);

        $isValid = $validator->validate();

        $this->assertTrue($isValid);
    }

    /**
     * Tests the validation of multilingual fields without explicitly
     *  specifying the language in the field name.
     */
    public function testValidateMultilangFieldsWithoutExplicitLanguage(): void
    {
        $fieldValues = [
            'age' => 30,
            'title.en' => 'Engineer',
            'title.pt' => 'Engenheiro',
        ];

        $fieldRules = [
            'age' => [
                'rules' => [
                    RuleEnum::REQUIRED,
                    RuleEnum::NUMERIC,
                ],
            ],
            'title.*' => [
                'rules' => [RuleEnum::REQUIRED],
            ],
        ];

        $validator = new Validator($fieldValues, $fieldRules, debugMode: true);

        $isValid = $validator->validate();

        $this->assertTrue($isValid);
    }

    /**
     * Tests the validation of multilingual fields without explicitly
     * specifying the language in the field name, with a missing required value.
     */
    public function testValidateMultilangFieldsWithoutExplicitLanguageMissingValue(): void
    {
        $fieldValues = [
            'title.en' => 'Engineer',
            // Missing value for the Portuguese language
            'title.pt' => '',
        ];

        $fieldRules = [
            'title.*' => [
                'rules' => [RuleEnum::REQUIRED],
            ],
        ];

        $validator = new Validator($fieldValues, $fieldRules, debugMode: true);

        $isValid = $validator->validate();

        $this->assertFalse($isValid);
    }

    /**
     * Tests the handling of multi-name fields that do not require validation.
     */
    public function testMultinameFieldsWithoutValidation(): void
    {
        $fieldValues = [
            'name' => 'John Doe',
            'title.en' => 'Engineer',
            'title.pt' => 'Engenheiro',
        ];

        $fieldRules = [
            'name' => [
                'rules' => [RuleEnum::REQUIRED],
            ],
        ];

        $validator = new Validator($fieldValues, $fieldRules, debugMode: true);

        $isValid = $validator->validate();

        $this->assertTrue($isValid);
    }

    /**
     * Tests the handling of multi-name fields that do not require validation
     *  but other fields require numeric validation.
     */
    public function testMultinameFieldsWithoutValidationPlusNumeric(): void
    {
        $fieldValues = [
            'name' => 'John Doe',
            'age' => 30,
            'title.en' => 'Engineer',
            'title.pt' => 'Engenheiro',
        ];

        $fieldRules = [
            'age' => [
                'rules' => [RuleEnum::NUMERIC],
            ],
            'name' => [
                'rules' => [RuleEnum::REQUIRED],
            ],
        ];

        $validator = new Validator($fieldValues, $fieldRules, debugMode: true);

        $isValid = $validator->validate();

        $this->assertTrue($isValid);
    }

    /**
     * Tests the validation of multi-name fields and ensures that the field
     *  name in the result matches the full name with the language.
     */
    public function testValidateMultiNameFieldsFullnameMatch(): void
    {
        $fieldValues = [
            'title.en' => '',
            'title.pt' => 'PT',
        ];

        $fieldRules = [
            'title.*' => [
                'rules' => [RuleEnum::REQUIRED],
            ],
        ];

        $expected = [
            'title.en' => [
                'label' => null,
                'rules' => [
                    'required' => 'This field is required.',
                ],
            ],
        ];

        $validator = new Validator($fieldValues, $fieldRules, debugMode: true);
        $validator->validate();
        $errors = $validator->getErrors();

        $this->assertEquals(
            \json_encode($expected),
            \json_encode($errors)
        );
    }

    /**
     * Test validation with a payload containing numeric keys in an array field.
     */
    public function testValidationWithNumericKeysInArrayField(): void
    {
        // Given a payload with numeric keys in an array field
        $payload = [
            'formToken' => '123...abc',
            'idTranslationValues' => [
                0 => 'add_link',
                1 => 'remove_link',
            ],
        ];

        // Define the field rules with the required rule for the idTranslationValues field
        $fieldRules = [
            'idTranslationValues' => [
                'rules' => [
                    'required' => true,
                ],
            ],
        ];

        // Create a Validator instance with the payload and rules
        $validator = new Validator($payload, $fieldRules, debugMode: true);

        // Perform validation
        $isValid = $validator->validate();

        $this->assertTrue($isValid);
    }

    /**
     * Test validation with an empty idTranslationValues field, which should fail due to its required nature.
     */
    public function testValidationWithEmptyIdTranslationValuesField(): void
    {
        // Given a payload with an empty idTranslationValues field
        $payload = [
            'formToken' => '123...abc',
            'idTranslationValues' => null,
        ];

        // Define the field rules with the required rule for the idTranslationValues field
        $fieldRules = [
            'idTranslationValues' => [
                'rules' => [
                    'required' => true,
                ],
            ],
        ];

        // Define the expected errors for the empty idTranslationValues field
        $expectedErrors = [
            'idTranslationValues' => [
                'label' => null,
                'rules' => [
                    'required' => 'This field is required.',
                ],
            ],
        ];

        // Create a Validator instance with the payload and rules
        $validator = new Validator($payload, $fieldRules, debugMode: true);

        // Perform validation
        $validator->validate();

        // Get the validation errors
        $errors = $validator->getErrors();

        // Assert that the validation errors match the expected errors
        $this->assertEquals(json_encode($expectedErrors), json_encode($errors));
    }
}
