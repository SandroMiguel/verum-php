<?php

/**
 * Rule Interface.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.1.0 (01/05/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

interface RuleInterface
{
    /**
     * Validate.
     *
     * @version 1.1.0 (01/05/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool;

    /**
     * Error Message Parameters.
     *
     * @return array<int, string|mixed> Returns the parameters for the error message.
     * ['param 1', 'param 2', ...]
     *
     * @version 1.0.0 (15/05/2020)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array;
}
