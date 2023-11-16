<?php

/**
 * Validator messages (dutch).
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Ariën Claij <clay.aar@gmail.com>
 * @copyright 2021 Ariën Claij
 * @since     Verum-PHP 1.0.0
 * @version   1.0.0 (21/07/2021)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

use Verum\Enum\RuleEnum;

return [
    RuleEnum::ALPHA => [
        'withLabel' => 'Het veld "{param:1}" moet letters (a-z) bevatten.',
        'withoutLabel' => 'Dit veld moet letters (a-z) bevatten.',
    ],
    RuleEnum::ALPHA_NUMERIC => [
        'withLabel' => 'Het veld "{param:1}" moet letters (a-z) en/of cijfers (0-9) bevatten.',
        'withoutLabel' => 'Dit veld moet letters (a-z) en/of cijfers (0-9) bevatten.',
    ],
    RuleEnum::BETWEEN => [
        'withLabel' => 'De waarde van het veld "{param:3}" moet tussen {param:1} en {param:2} liggen.',
        'withoutLabel' => 'De waarde van dit veld moet tussen {param:1} en {param:2} liggen.',
    ],
    RuleEnum::BETWEEN_LENGTH => [
        'withLabel' => 'De waarde van het veld "{param:3}" moet tussen {param:1} en {param:2} tekens liggen.',
        'withoutLabel' => 'De waarde van dit veld moet tussen {param:1} en {param:2} tekens liggen.',
    ],
    RuleEnum::BOOLEAN_VALUE => [
        'withLabel' => 'Het veld "{param:1}" moet een boolean bevatten.',
        'withoutLabel' => 'Dit veld moet een boolean bevatten.',
    ],
    RuleEnum::CONTAINS => [
        'withLabel' => 'Het veld "{param:3}" moet de waarde "{param:1}" bevatten. Geldige waardes zijn: {param:2}',
        'withoutLabel' => 'Dit veld moet de waarde "{param:1}" bevatten. Geldige waardes zijn: {param:2}',
    ],
    RuleEnum::DATE => [
        'withLabel' => 'Het veld "{param:2}" moet een geldige datum in dit formaat bevatten: "{param:1}"',
        'withoutLabel' => 'Dit veld moet een geldige datum in dit formaat bevatten: "{param:1}"',
    ],
    RuleEnum::EMAIL => [
        'withLabel' => 'Het veld "{param:1}" moet een geldig e-mail adres bevatten.',
        'withoutLabel' => 'Dit veld moet een geldig e-mail adres bevatten.',
    ],
    RuleEnum::EQUALS => [
        'withLabel' => 'De velden {param:1} en {param:2} moeten hetzelfde zijn.',
        'withoutLabel' => 'De velden moeten hetzelfde zijn.',
    ],
    RuleEnum::FILE_MAX_SIZE => [
        'withLabel' => 'Het veld "{param:3}" bevat een bestandsgrootte van {param:1}. De waarde moet minder zijn dan {param:2}.',
        'withoutLabel' => 'Dit veld bevat een bestandsgrootte van {param:1}. De waarde moet minder zijn dan {param:2}.',
    ],
    RuleEnum::FILE_MIME_TYPE => [
        'withLabel' => 'Het veld "{param:3}" bevat een bestand van het type {param:1}. Het type moet {param:2} zijn.',
        'withoutLabel' => 'Dit veld bevat een bestand van het type {param:1}. Het type moet {param:2} zijn.',
    ],
    RuleEnum::FLOAT_NUMBER => [
        'withLabel' => 'Het veld "{param:1}" moet een getal met een punt als komma bevatten.',
        'withoutLabel' => 'Dit veld moet een getal met een punt als komma bevatten.',
    ],
    RuleEnum::IMAGE_MAX_HEIGHT => [
        'withLabel' => 'De hoogte van de geüploade afbeelding in het veld "{param:3}" is {param:1}px. De maximale hoogte is {param:2} px.',
        'withoutLabel' => 'De hoogte van de geüploade afbeelding is {param:1}px. De maximale hoogte is {param:2} px.',
    ],
    RuleEnum::IMAGE_MAX_WIDTH => [
        'withLabel' => 'De hoogte van de geüploade afbeelding in het veld "{param:3}" is {param:1}px. De maximale breedte is {param:2} px.',
        'withoutLabel' => 'De hoogte van de geüploade afbeelding is {param:1}px. De maximale breedte is {param:2} px.',
    ],
    RuleEnum::IMAGE_MIN_HEIGHT => [
        'withLabel' => 'De hoogte van de geüploade afbeelding in het veld "{param:3}" is {param:1}px. De minimale hoogte is {param:2} px.',
        'withoutLabel' => 'De hoogte van de geüploade afbeelding is {param:1}px. De minimale hoogte is {param:2} px.',
    ],
    RuleEnum::IMAGE_MIN_WIDTH => [
        'withLabel' => 'De breedte van de geüploade afbeelding in het veld "{param:3}" is {param:1}px. De minimale breedte is {param:2} px.',
        'withoutLabel' => 'De breedte van de geüploade afbeelding is {param:1}px. De minimale breedte is {param:2} px.',
    ],
    RuleEnum::INTEGER => [
        'withLabel' => 'Het veld "{param:1}" moet een geheel getal zijn.',
        'withoutLabel' => 'Dit veld moet een geheel getal zijn.',
    ],
    RuleEnum::IP => [
        'withLabel' => 'Het veld "{param:1}" moet een geldig IP-adres bevatten.',
        'withoutLabel' => 'Dit veld moet een geldig IP-adres bevatten.',
    ],
    RuleEnum::IPV4 => [
        'withLabel' => 'Het veld "{param:1}" moet een geldig IPv4-adres bevatten.',
        'withoutLabel' => 'Dit veld moet een geldig IPv4-adres bevatten.',
    ],
    RuleEnum::IPV6 => [
        'withLabel' => 'Het veld "{param:1}" moet een geldig IPv6-adres bevatten.',
        'withoutLabel' => 'Dit veld moet een geldig IPv6-adres bevatten.',
    ],
    RuleEnum::MAX => [
        'withLabel' => 'Het veld "{param:2}" mag niet hoger dan {param:1} zijn.',
        'withoutLabel' => 'Dit veld mag niet hoger dan {param:1} zijn.',
    ],
    RuleEnum::MAX_LENGTH => [
        'withLabel' => 'Het veld "{param:2}" mag niet groter zijn dan {param:1} tekens.',
        'withoutLabel' => 'Dit veld mag niet groter zijn dan {param:1} tekens.',
    ],
    RuleEnum::MIN => [
        'withLabel' => 'Het veld "{param:2}" moet minstens {param:1} zijn.',
        'withoutLabel' => 'De waarde van dit veld moet minstens {param:1} zijn.',
    ],
    RuleEnum::MIN_LENGTH => [
        'withLabel' => 'Het veld "{param:2}" moet minimaal {param:1} tekens lang zijn.',
        'withoutLabel' => 'Dit veld moet minimaal {param:1} tekens lang zijn.',
    ],
    RuleEnum::NUMERIC => [
        'withLabel' => 'Het veld "{param:1}" moet een numerieke waarde hebben.',
        'withoutLabel' => 'Het veld moet een numerieke waarde hebben.',
    ],
    RuleEnum::REGEX => [
        'withLabel' => 'Het veld "{param:2}" voldoet niet aan het juiste patroon {param:1}.',
        'withoutLabel' => 'Dit veld voldoet niet aan het juiste patroon {param:1}.',
    ],
    RuleEnum::REQUIRED => [
        'withLabel' => 'Het veld "{param:1}" is verplicht.',
        'withoutLabel' => 'Dit veld is verplicht.',
    ],
    RuleEnum::REQUIRED_IF => [
        'withLabel' => 'Het veld "{param:1}" is verplicht.',
        'withoutLabel' => 'Dit veld is verplicht.',
    ],
    RuleEnum::REQUIRED_IF_NOT => [
        'withLabel' => 'Het veld "{param:1}" is verplicht.',
        'withoutLabel' => 'Dit veld is verplicht.',
    ],
    RuleEnum::SLUG => [
        'withLabel' => 'Het veld "{param:1}" moet een geldige slug bevatten (bijv. hallo-wereld_123).',
        'withoutLabel' => 'Dit veld moet een geldige slug bevatten (bijv. hallo-wereld_123).',
    ],
    RuleEnum::URL => [
        'withLabel' => 'Het veld "{param:1}" moet een geldige URL bevatten.',
        'withoutLabel' => 'Dit veld moet een geldige URL bevatten.',
    ],
];
