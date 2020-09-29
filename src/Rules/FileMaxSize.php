<?php

/**
 * FileMaxSize rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   3.0.3 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exceptions\ValidatorException;

/**
 * Class FileMaxSize | src/Rules/FileMaxSize.php
 * Checks whether the file size does not exceed a given value.
 */
final class FileMaxSize extends Rule
{
    /** @var mixed File size */
    private $size;

    /** @var int Max file size (bytes) */
    private $maxSize;

    /**
     * FileMaxSize constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.0.1 (24/06/2020)
     * @since   Verum 1.0.0
     */
    public function __construct($fieldValue)
    {
        $this->size = $fieldValue['size'] ?? null;
    }

    /**
     * Validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 1.2.2 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "file_max_size": the rule value is mandatory'
            );
        }
        if (!is_int($this->ruleValues[0])) {
            throw ValidatorException::noIntegerValue(
                $this->ruleValues[0] ?? 'null',
                'The "max size" parameter should be an integer value.'
            );
        }
        $this->maxSize = $this->ruleValues[0];

        return $this->size < $this->maxSize;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 2.0.0 (16/06/2020)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [
            $this->formatBytes($this->size),
            $this->formatBytes($this->maxSize),
            $this->fieldLabel,
        ];
    }

    /**
     * Format a number of Bytes to MB, GB, etc.
     * E.g. 10485760 -> 10 MB
     *
     * @param int $bytes Value in Bytes.
     * @param int $precision Precision (decimal digits to round to).
     *
     * @return string Returns the value as appropriate.
     *
     * @version 1.1.2 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = (int) min($pow, count($units) - 1);

        $bytes /= 1024 ** $pow;

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
