<?php

/**
 * Validator messages (English).
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.2 (2020/10/31)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

use Verum\Enum\RuleEnum;

return [
    RuleEnum::ALPHA => [
        'withLabel' => 'The "{param:1}" field must contain letters only (a-z).',
        'withoutLabel' => 'This field must contain letters only (a-z).',
    ],
    RuleEnum::ALPHA_NUMERIC => [
        'withLabel' => 'The "{param:1}" field must contain only letters (a-z) and digits (0-9).',
        'withoutLabel' => 'This field must contain only letters (a-z) and digits (0-9).',
    ],
    RuleEnum::BETWEEN => [
        'withLabel' => 'The "{param:3}" field must be between {param:1} and {param:2}.',
        'withoutLabel' => 'This field must be between {param:1} and {param:2}.',
    ],
    RuleEnum::BETWEEN_LENGTH => [
        'withLabel' => 'The "{param:3}" field must be between {param:1} and {param:2} characters.',
        'withoutLabel' => 'This field must be between {param:1} and {param:2} characters.',
    ],
    RuleEnum::BOOLEAN_VALUE => [
        'withLabel' => 'The "{param:1}" field must be a boolean value.',
        'withoutLabel' => 'This field must be a boolean value.',
    ],
    RuleEnum::CONTAINS => [
        'withLabel' => 'The "{param:3}" field contains the value "{param:1}". The valid values are: {param:2}',
        'withoutLabel' => 'This field contains the value "{param:1}". The valid values are: {param:2}',
    ],
    RuleEnum::DATE => [
        'withLabel' => 'The "{param:2}" field must be a valid date in the format "{param:1}"',
        'withoutLabel' => 'This field must be a valid date in the format "{param:1}"',
    ],
    RuleEnum::EMAIL => [
        'withLabel' => 'The "{param:1}" field must be a valid email address.',
        'withoutLabel' => 'This field must be a valid email address.',
    ],
    RuleEnum::EQUALS => [
        'withLabel' => 'The {param:1} and {param:2} fields must be the same.',
        'withoutLabel' => 'Please enter the same value again.',
    ],
    RuleEnum::FILE_MAX_SIZE => [
        'withLabel' => 'The "{param:3}" field contains a file size with {param:1}. The file size must be less than {param:2}.',
        'withoutLabel' => 'This field contains a file size with {param:1}. The file size must be less than {param:2}.',
    ],
    RuleEnum::FILE_MIME_TYPE => [
        'withLabel' => 'The "{param:3}" field contains an {param:1} file. The file type must be {param:2}',
        'withoutLabel' => 'This field contains an {param:1} file. The file type must be {param:2}',
    ],
    RuleEnum::FLOAT_NUMBER => [
        'withLabel' => 'The "{param:1}" field must be a floating point number.',
        'withoutLabel' => 'This field must be a floating point number.',
    ],
    RuleEnum::IMAGE_MAX_HEIGHT => [
        'withLabel' => 'The uploaded image height of the "{param:3}" field is {param:1}px. The maximum allowed height is {param:2}px.',
        'withoutLabel' => 'The uploaded image height of this field is {param:1}px. The maximum allowed height is {param:2}px.',
    ],
    RuleEnum::IMAGE_MAX_WIDTH => [
        'withLabel' => 'The uploaded image width of the "{param:3}" field is {param:1}px. The maximum width is {param:2}px.',
        'withoutLabel' => 'The uploaded image width of this field is {param:1}px. The maximum width is {param:2}px.',
    ],
    RuleEnum::IMAGE_MIN_HEIGHT => [
        'withLabel' => 'The uploaded image height of the "{param:3}" field is {param:1}px. The minimum height is {param:2}px.',
        'withoutLabel' => 'The uploaded image height of this field is {param:1}px. The minimum height is {param:2}px.',
    ],
    RuleEnum::IMAGE_MIN_WIDTH => [
        'withLabel' => 'The uploaded image width of the "{param:3}" field is {param:1}px. The minimum width is {param:2}px.',
        'withoutLabel' => 'The uploaded image width of this field is {param:1}px. The minimum width is {param:2}px.',
    ],
    RuleEnum::IP => [
        'withLabel' => 'The "{param:1}" field must be a valid IP address.',
        'withoutLabel' => 'This field must be a valid IP address.',
    ],
    RuleEnum::IPV4 => [
        'withLabel' => 'The "{param:1}" field must be a valid IPv4 address.',
        'withoutLabel' => 'This field must be a valid IPv4 address.',
    ],
    RuleEnum::IPV6 => [
        'withLabel' => 'The "{param:1}" field must be a valid IPv6 address.',
        'withoutLabel' => 'This field must be a valid IPv6 address.',
    ],
    RuleEnum::MAX => [
        'withLabel' => '"{param:2}" must be no more than {param:1}.',
        'withoutLabel' => 'The value of this field must be no more than {param:1}.',
    ],
    RuleEnum::MAX_LENGTH => [
        'withLabel' => 'The "{param:2}" field must not exceed {param:1} characters.',
        'withoutLabel' => 'This field must not exceed {param:1} characters.',
    ],
    RuleEnum::MIN => [
        'withLabel' => '"{param:2}" must be at least {param:1}.',
        'withoutLabel' => 'The value of this field must be at least {param:1}.',
    ],
    RuleEnum::MIN_LENGTH => [
        'withLabel' => 'The "{param:2}" field must be at least {param:1} characters long.',
        'withoutLabel' => 'This field must be at least {param:1} characters long.',
    ],
    RuleEnum::NUMERIC => [
        'withLabel' => 'The "{param:1}" field must be numeric.',
        'withoutLabel' => 'This field must be numeric.',
    ],
    RuleEnum::REGEX => [
        'withLabel' => 'The "{param:2}" field does not match against pattern {param:1}',
        'withoutLabel' => 'This field does not match against pattern {param:1}',
    ],
    RuleEnum::REQUIRED => [
        'withLabel' => 'The "{param:1}" field is required.',
        'withoutLabel' => 'This field is required.',
    ],
    RuleEnum::REQUIRED_IF => [
        'withLabel' => 'The "{param:1}" field is required.',
        'withoutLabel' => 'This field is required.',
    ],
    RuleEnum::REQUIRED_IF_NOT => [
        'withLabel' => 'The "{param:1}" field is required.',
        'withoutLabel' => 'This field is required.',
    ],
    RuleEnum::SLUG => [
        'withLabel' => 'The "{param:1}" field must be a valid slug (e.g. hello-world_123).',
        'withoutLabel' => 'This field must be a valid slug (e.g. hello-world_123).',
    ],
    RuleEnum::URL => [
        'withLabel' => 'The "{param:1}" field must be a valid URL.',
        'withoutLabel' => 'This field must be a valid URL.',
    ],
];
