<?php

/**
 * Verum Languages enumerator.
 *
 * PHP Version 7.2.11-3
 *
 * @package Verum-PHP
 * @license MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2021 Sandro
 * @since Verum-PHP 1.0.0
 * @version 1.2.0 (2021/07/27)
 * @link https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Enum;

/**
 * Class LangEnum | src/Enum/LangEnum.php
 */
abstract class LangEnum
{
    public const EN = 'en';
    public const NL_NL = 'nl-nl';
    public const PT_BR = 'pt-br';
    public const PT_PT = 'pt-pt';

    /**
     * Get language constants.
     *
     * @return array<string> Returns the language list.
     *
     * @version 1.0.2 (2021/07/27)
     * @since Verum 1.0.0
     */
    public static function getConstants(): array
    {
        $class = new \ReflectionClass(self::class);

        return $class->getConstants();
    }
}
