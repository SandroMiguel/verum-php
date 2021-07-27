<?php

/**
 * Verum Rules enumerator.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.10.0 (10/05/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Enum;

/**
 * Class RuleEnum | src/Enum/RuleEnum.php
 */
abstract class RuleEnum
{
    public const ALPHA = 'alpha';
    public const ALPHA_NUMERIC = 'alpha_numeric';
    public const BETWEEN = 'between';
    public const BETWEEN_LENGTH = 'between_length';
    public const BOOLEAN_VALUE = 'boolean_value';
    public const CONTAINS = 'contains';
    public const DATE = 'date';
    public const EMAIL = 'email';
    public const EQUALS = 'equals';
    public const FILE_MAX_SIZE = 'file_max_size';
    public const FILE_MIME_TYPE = 'file_mime_type';
    public const FLOAT_NUMBER = 'float_number';
    public const IMAGE_MAX_HEIGHT = 'image_max_height';
    public const IMAGE_MAX_WIDTH = 'image_max_width';
    public const IMAGE_MIN_HEIGHT = 'image_min_height';
    public const IMAGE_MIN_WIDTH = 'image_min_width';
    public const IP = 'ip';
    public const IPV4 = 'ipv4';
    public const IPV6 = 'ipv6';
    public const MAX = 'max';
    public const MAX_LENGTH = 'max_length';
    public const MIN = 'min';
    public const MIN_LENGTH = 'min_length';
    public const NUMERIC = 'numeric';
    public const REGEX = 'regex';
    public const REQUIRED = 'required';
    public const SLUG = 'slug';
    public const URL = 'url';
    public const REQUIRED_IF = 'required_if';
    public const REQUIRED_IF_NOT = 'required_if_not';
}
