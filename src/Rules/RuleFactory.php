<?php

/**
 * Rule Factory.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.11.1 (16/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Validator;
use Verum\ValidatorException;

/**
 * Class RuleFactory | src/Rules/RuleFactory.php | Rule factory
 */
final class RuleFactory
{
    /**
     * Load Rule.
     *
     * @param Validator $validator Validator object.
     * @param mixed $fieldValue Field Value to validate.
     * @param array<mixed> $ruleValues Rule values.
     * @param string $fieldName Field name.
     * @param string $ruleName Rule name.
     * @param string|null $label Label.
     *
     * @return Rule Returns a rule object.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 1.11.1 (2020/06/16)
     * @since   Verum 1.0.0
     */
    public static function loadRule(
        Validator $validator,
        $fieldValue,
        array $ruleValues,
        string $fieldName,
        string $ruleName,
        ?string $label
    ): Rule {
        $className = 'Verum\\Rules\\' . self::snakeCaseToPascalCase($ruleName);
        if (!class_exists($className)) {
            throw ValidatorException::ruleNotFound($ruleName);
        }

        $class = new \ReflectionClass($className);
        $ruleInstance = $class->newInstanceArgs([$fieldValue]);
        $ruleInstance->setValidator($validator);
        $ruleInstance->setRuleValues($ruleValues);
        $ruleInstance->setFieldNameUnderTest($fieldName);
        $ruleInstance->setFieldLabel($label);

        return $ruleInstance;
    }

    /**
     * Converts Snake case to Pascal case (hello_world -> HelloWorld).
     *
     * @param string $text Text to convert.
     *
     * @return string Returns the text converted to Pascal case.
     */
    private static function snakeCaseToPascalCase(string $text): string
    {
        return str_replace('_', '', ucwords($text, '_'));
    }
}
