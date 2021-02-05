<?php

/**
 * Image Max Width rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.1 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exception\ValidatorException;

/**
 * Class ImageMaxWidth | src/Rules/ImageMaxWidth.php
 * Checks whether the image width does not exceed a given value.
 */
final class ImageMaxWidth extends Rule
{
    /** @var mixed Image width */
    private $imageWidth;

    /** @var int Max width */
    private $maxWidth;

    /**
     * ImageMaxWidth constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.0.0 (10/06/2020)
     * @since   Verum 1.0.0
     */
    public function __construct($fieldValue)
    {
        $this->imageWidth = isset($fieldValue['tmp_name'])
            ? getimagesize($fieldValue['tmp_name'])[0]
            : null;
    }

    /**
     * Validates the field value against the rule.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @version 2.1.3 (25/06/2020)
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
                'Rule "image_max_width": the rule value is mandatory'
            );
        }
        $this->maxWidth = $this->ruleValues[0];

        if (!$this->imageWidth) {
            return true;
        }
        $max = new Max($this->imageWidth);
        $max->setRuleValues([$this->maxWidth]);

        return $max->validate();
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, mixed> Returns the parameters for the error message.
     *
     * @version 2.0.0 (16/06/2020)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->imageWidth, $this->maxWidth, $this->fieldLabel];
    }
}
