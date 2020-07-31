<?php

/**
 * Validator messages (english).
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.1 (2020/06/20)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

return [
    'alpha' => [
        'withLabel' => 'The "{param:1}" field must contain letters only (a-z).',
        'withoutLabel' => 'This field must contain letters only (a-z).',
    ],
    'alpha_numeric' => [
        'withLabel' => 'The "{param:1}" field must contain only letters (a-z) and digits (0-9).',
        'withoutLabel' => 'This field must contain only letters (a-z) and digits (0-9).',
    ],
    'between' => [
        'withLabel' => 'The "{param:3}" field must be between {param:1} and {param:2}.',
        'withoutLabel' => 'This field must be between {param:1} and {param:2}.',
    ],
    'between_length' => [
        'withLabel' => 'The "{param:3}" field must be between {param:1} and {param:2} characters.',
        'withoutLabel' => 'This field must be between {param:1} and {param:2} characters.',
    ],
    'boolean_value' => [
        'withLabel' => 'The "{param:1}" field must be a boolean value.',
        'withoutLabel' => 'This field must be a boolean value.',
    ],
    'contains' => [
        'withLabel' => 'The "{param:3}" field contains the value "{param:1}". The valid values are: {param:2}',
        'withoutLabel' => 'This field contains the value "{param:1}". The valid values are: {param:2}',
    ],
    'date' => [
        'withLabel' => 'The "{param:2}" field must be a valid date in the format "{param:1}"',
        'withoutLabel' => 'This field must be a valid date in the format "{param:1}"',
    ],
    'email' => [
        'withLabel' => 'The "{param:1}" field must be a valid email address.',
        'withoutLabel' => 'This field must be a valid email address.',
    ],
    'equals' => [
        'withLabel' => 'The {param:1} and {param:2} fields must be the same.',
        'withoutLabel' => 'Please enter the same value again.',
    ],
    'file_max_size' => [
        'withLabel' => 'The "{param:3}" field contains a file size with {param:1}. The file size must be less than {param:2}.',
        'withoutLabel' => 'This field contains a file size with {param:1}. The file size must be less than {param:2}.',
    ],
    'file_mime_type' => [
        'withLabel' => 'The "{param:3}" field contains an {param:1} file. The file type must be {param:2}',
        'withoutLabel' => 'This field contains an {param:1} file. The file type must be {param:2}',
    ],
    'float_number' => [
        'withLabel' => 'The "{param:1}" field must be a floating point number.',
        'withoutLabel' => 'This field must be a floating point number.',
    ],
    'image_max_height' => [
        'withLabel' => 'The uploaded image height of the "{param:3}" field is {param:1}px. The maximum allowed height is {param:2}px.',
        'withoutLabel' => 'The uploaded image height of this field is {param:1}px. The maximum allowed height is {param:2}px.',
    ],
    'image_max_width' => [
        'withLabel' => 'The uploaded image width of the "{param:3}" field is {param:1}px. The maximum width is {param:2}px.',
        'withoutLabel' => 'The uploaded image width of this field is {param:1}px. The maximum width is {param:2}px.',
    ],
    'image_min_height' => [
        'withLabel' => 'The uploaded image height of the "{param:3}" field is {param:1}px. The minimum height is {param:2}px.',
        'withoutLabel' => 'The uploaded image height of this field is {param:1}px. The minimum height is {param:2}px.',
    ],
    'image_min_width' => [
        'withLabel' => 'The uploaded image width of the "{param:3}" field is {param:1}px. The minimum width is {param:2}px.',
        'withoutLabel' => 'The uploaded image width of this field is {param:1}px. The minimum width is {param:2}px.',
    ],
    'ip' => [
        'withLabel' => 'The "{param:1}" field must be a valid IP address.',
        'withoutLabel' => 'This field must be a valid IP address.',
    ],
    'ipv4' => [
        'withLabel' => 'The "{param:1}" field must be a valid IPv4 address.',
        'withoutLabel' => 'This field must be a valid IPv4 address.',
    ],
    'ipv6' => [
        'withLabel' => 'The "{param:1}" field must be a valid IPv6 address.',
        'withoutLabel' => 'This field must be a valid IPv6 address.',
    ],
    'max' => [
        'withLabel' => '"{param:2}" must be no more than {param:1}.',
        'withoutLabel' => 'The value of this field must be no more than {param:1}.',
    ],
    'max_length' => [
        'withLabel' => 'The "{param:2}" field must not exceed {param:1} characters.',
        'withoutLabel' => 'This field must not exceed {param:1} characters.',
    ],
    'min' => [
        'withLabel' => '"{param:2}" must be at least {param:1}.',
        'withoutLabel' => 'The value of this field must be at least {param:1}.',
    ],
    'min_length' => [
        'withLabel' => 'The "{param:2}" field must be at least {param:1} characters long.',
        'withoutLabel' => 'This field must be at least {param:1} characters long.',
    ],
    'numeric' => [
        'withLabel' => 'The "{param:1}" field must be numeric.',
        'withoutLabel' => 'This field must be numeric.',
    ],
    'regex' => [
        'withLabel' => 'The "{param:2}" field does not match against pattern {param:1}.',
        'withoutLabel' => 'This field does not match against pattern {param:1}.',
    ],
    'required' => [
        'withLabel' => 'The "{param:1}" field is required.',
        'withoutLabel' => 'This field is required.',
    ],
    'slug' => [
        'withLabel' => 'The "{param:1}" field must be a valid slug (e.g. hello-world_123).',
        'withoutLabel' => 'This field must be a valid slug (e.g. hello-world_123).',
    ],
    'url' => [
        'withLabel' => 'The "{param:1}" field must be a valid URL.',
        'withoutLabel' => 'This field must be a valid URL.',
    ],
];
