<?php

/**
 * Image Max Height rule.
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
 * Class ImageMaxHeight | core/Verum/Rules/ImageMaxHeight.php
 * Checks whether the image height does not exceed a given value.
 */
final class ImageMaxHeight extends Rule
{
    /** @var mixed Image height */
    private $imageHeight;

    /** @var int Max height */
    private $maxHeight;

    /**
     * ImageMaxHeight constructor.
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
        $this->imageHeight = isset($fieldValue['tmp_name'])
            ? getimagesize($fieldValue['tmp_name'])[1]
            : null;
    }

    /**
     * Validate.
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
                'Rule "image_max_height": the rule value is mandatory'
            );
        }
        $this->maxHeight = $this->ruleValues[0];

        if (!$this->imageHeight) {
            return true;
        }

        $max = new Max($this->imageHeight);
        $max->setRuleValues([$this->maxHeight]);

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
        return [$this->imageHeight, $this->maxHeight, $this->fieldLabel];
    }
}
