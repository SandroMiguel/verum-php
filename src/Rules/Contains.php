<?php

/**
 * Contains rule.
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
 * Class Contains | core/Verum/Rules/Contains.php
 * Checks whether the value is in an array.
 */
final class Contains extends Rule
{
    /** @var array<mixed> Values to compare */
    private $valuesToCompare;

    /**
     * Contains constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @version 2.0.0 (10/06/2020)
     * @since   Verum 1.0.0
     */
    public function __construct($fieldValue)
    {
        $this->fieldValue = $fieldValue;
    }

    /**
     * Validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.1.2 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "contains": the rule values are mandatory'
            );
        }
        $this->valuesToCompare = $this->ruleValues;

        if ($this->fieldValue === '') {
            return true;
        }

        return in_array($this->fieldValue, $this->valuesToCompare);
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
            $this->fieldValue,
            implode(', ', $this->valuesToCompare),
            $this->fieldLabel,
        ];
    }
}
