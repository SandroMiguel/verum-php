<?php

/**
 * ArrayHelper.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 2.0.0
 * @version   1.0.0 (2020/09/29)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum;

/**
 * Class ArrayHelper | src/ArrayHelper.php
 * Utility class for arrays.
 */
class ArrayHelper
{
    /**
     * Convert array to string.
     *
     * @param array $theArray The array to be converted
     *
     * @return string Returns the stringified array.
     */
    public static function arrayToString(array $theArray): string
    {
        return json_encode($theArray);
    }
}
