<?php

/**
 * Validator Exception.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   5.0.0 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum;

/**
 * ValidatorException class
 */
final class ValidatorException extends \Exception
{
    /**
     * Invalid argument.
     *
     * @param string $argumentName Argument name.
     * @param mixed $argumentValue Argument value.
     * @param string $customMessage Custom message.
     * @param int $code Error code.
     * @param \Throwable $previous Previous exception.
     *
     * @return ValidatorException
     *
     * @version 3.0.0 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public static function invalidArgument(
        string $argumentName,
        $argumentValue,
        ?string $customMessage = null,
        int $code = 0,
        ?\Throwable $previous = null
    ): self {
        $errorMessage = sprintf(
            'Invalid argument; Argument name: %s; Argument value: %s',
            $argumentName,
            $argumentValue ?? 'null'
        );
        if ($customMessage) {
            $errorMessage .= "; {$customMessage}";
        }
        if ($previous) {
            $errorMessage .= "; {$previous->getMessage()}";
        }
        return new static($errorMessage, $code, $previous);
    }

    /**
     * Invalid property.
     *
     * @param string $property Property.
     * @param string $customMessage Custom message.
     *
     * @return ValidatorException
     *
     * @version 1.0.1 (08/06/2020)
     * @since   Verum 1.0.0
     */
    public static function invalidProperty(
        string $property,
        ?string $customMessage = null
    ): self {
        $errorMessage = sprintf('Invalid property; Property: %s', $property);
        if ($customMessage) {
            $errorMessage .= "; {$customMessage}";
        }

        return new static($errorMessage);
    }

    /**
     * Invalid rule message argument.
     *
     * @param string $ruleMessage Rule message.
     * @param array<string> $args Arguments.
     * @param int $code Error code.
     * @param \Throwable $previous Previous exception.
     *
     * @return ValidatorException
     *
     * @version 1.1.1 (23/05/2020)
     * @since   Verum 1.0.0
     */
    public static function invalidRuleMessageArgument(
        string $ruleMessage,
        array $args,
        int $code,
        \Throwable $previous
    ): self {
        $errorMessage = sprintf(
            '%s; Message: %s; Arguments: %s',
            $previous->getMessage(),
            $ruleMessage,
            $args ? implode(',', $args) : 'NULL'
        );
        return new static($errorMessage, $code, $previous);
    }

    /**
     * Rule Message not found Exception.
     *
     * @param string $ruleName Rule name.
     *
     * @return ValidatorException
     *
     * @version 1.0.0 (03/05/2020)
     * @since   Verum 1.0.0
     */
    public static function ruleMessageNotFound(string $ruleName): self
    {
        return new static(
            "The message for \"{$ruleName}\" rule was not found."
        );
    }

    /**
     * No Fields Exception.
     *
     * @return ValidatorException
     *
     * @version 1.0.0 (03/05/2020)
     * @since   Verum 1.0.0
     */
    public static function noFields(): self
    {
        return new static('There is no fields to process.');
    }

    /**
     * No Valid Integer Value Exception.
     *
     * @param mixed $ruleValue Rule value.
     * @param string $message Additional message.
     *
     * @return ValidatorException
     *
     * @version 1.1.0 (21/05/2020)
     * @since   Verum 1.0.0
     */
    public static function noIntegerValue(
        $ruleValue,
        ?string $message = null
    ): self {
        $errorMessage = "\"{$ruleValue}\" is not an integer value.";
        if ($message) {
            $errorMessage .= " {$message}";
        }

        return new static($errorMessage);
    }

    /**
     * No Rules Exception.
     *
     * @return ValidatorException
     *
     * @version 1.0.0 (03/05/2020)
     * @since   Verum 1.0.0
     */
    public static function noRules(): self
    {
        return new static('There is no rules to process.');
    }

    /**
     * No Translation File Exception.
     *
     * @param string $lang Language.
     *
     * @return ValidatorException
     *
     * @version 1.0.0 (03/05/2020)
     * @since   Verum 1.0.0
     */
    public static function noTranslation(string $lang): self
    {
        return new static(
            "The translation file for \"{$lang}\" language doesn't exist"
        );
    }

    /**
     * Rule Not Found Exception.
     *
     * @param string $ruleName Rule name.
     * @param int $code Error code.
     * @param \Throwable $previous Previous exception.
     *
     * @return ValidatorException
     *
     * @version 2.1.1 (10/05/2020)
     * @since   Verum 1.0.0
     */
    public static function ruleNotFound(
        string $ruleName,
        int $code = 0,
        ?\Throwable $previous = null
    ): self {
        $errorMessage = "The \"{$ruleName}\" rule was not found.";
        if ($previous) {
            $errorMessage .= " {$previous->getMessage()}";
        }
        return new static($errorMessage, $code, $previous);
    }
}
