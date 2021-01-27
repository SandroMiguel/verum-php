<?php

/**
 * FileMimeType rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   3.0.1 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exceptions\ValidatorException;

/**
 * Class FileMimeType | src/Rules/FileMimeType.php
 * Checks whether the file type is allowed.
 */
final class FileMimeType extends Rule
{
    /** @var mixed File MIME type */
    private $mimeType;

    /** @var array<string> Allowed MIME types */
    private $allowedMimeTypes;

    /**
     * FileMimeType constructor.
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
        $this->mimeType = $fieldValue['type'] ?? null;
    }

    /**
     * Validates the field value against the rule.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @version 1.1.2 (25/06/2020)
     * @since   Verum 1.0.0
     *
     * @throws ValidatorException Validator Exception.
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "file_mime_type": the rule value is mandatory'
            );
        }
        $this->allowedMimeTypes = $this->ruleValues;

        return isset($this->mimeType)
            ? in_array($this->mimeType, $this->allowedMimeTypes)
            : true;
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
            $this->mimeType,
            implode(', ', $this->allowedMimeTypes),
            $this->fieldLabel,
        ];
    }
}
