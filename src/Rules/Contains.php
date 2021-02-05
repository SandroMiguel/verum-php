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
 * @version   4.0.2 (2020/09/29)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exception\ValidatorException;

/**
 * Class Contains | src/Rules/Contains.php
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
     * @version 2.0.0 (2020/06/10)
     * @since   Verum 1.0.0
     */
    public function __construct($fieldValue)
    {
        $this->fieldValue = $fieldValue;
    }

    /**
     * Validates the field value against the rule.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.1.3 (2020/09/29)
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

        if ($this->fieldValue === 0 || $this->fieldValue === true) {
            return false;
        }
        if ($this->fieldValue === null || $this->fieldValue === '') {
            return true;
        }

        return in_array($this->fieldValue, $this->valuesToCompare);
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     * [Field value, Placeholders, Field label]
     *
     * @version 2.0.1 (2020/09/29)
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
