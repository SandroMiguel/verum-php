<?php

/**
 * Image Min Width rule.
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

use Verum\Exceptions\ValidatorException;

/**
 * Class ImageMinWidth | src/Rules/ImageMinWidth.php
 * Checks whether the image width is not less than a given value.
 */
final class ImageMinWidth extends Rule
{
    /** @var mixed Image width */
    private $imageWidth;

    /** @var int Min width */
    private $minWidth;

    /**
     * ImageMinWidth constructor.
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
     * Validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.1.3 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "image_min_width": the rule value is mandatory'
            );
        }
        $this->minWidth = $this->ruleValues[0];

        if (!$this->imageWidth) {
            return true;
        }
        $min = new Min($this->imageWidth);
        $min->setRuleValues([$this->minWidth]);

        return $min->validate();
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
        return [$this->imageWidth, $this->minWidth, $this->fieldLabel];
    }
}
