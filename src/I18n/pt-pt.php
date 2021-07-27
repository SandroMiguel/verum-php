<?php

/**
 * Validator messages (Portuguese-Portugal).
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.2.2 (2020/10/31)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

use Verum\Enum\RuleEnum;

return [
    RuleEnum::ALPHA => [
        'withLabel' => 'O campo "{param:1}" deve conter apenas letras (a-z).',
        'withoutLabel' => 'Este campo deve conter apenas letras (a-z).',
    ],
    RuleEnum::ALPHA_NUMERIC => [
        'withLabel' => 'O campo "{param:1}" deve conter apenas letras (a-z) e números (0-9).',
        'withoutLabel' => 'Este campo deve conter apenas letras (a-z) e números (0-9).',
    ],
    RuleEnum::BETWEEN => [
        'withLabel' => 'O campo "{param:3}" só permite valores entre {param:1} e {param:2}.',
        'withoutLabel' => 'Este campo só permite valores entre {param:1} e {param:2}.',
    ],
    RuleEnum::BETWEEN_LENGTH => [
        'withLabel' => 'O campo "{param:3}" deve ter entre {param:1} e {param:2} caracteres.',
        'withoutLabel' => 'Este campo deve ter entre {param:1} e {param:2} caracteres.',
    ],
    RuleEnum::BOOLEAN_VALUE => [
        'withLabel' => 'O campo "{param:1}" deve ser um valor booleano.',
        'withoutLabel' => 'Este campo deve ser um valor booleano.',
    ],
    RuleEnum::CONTAINS => [
        'withLabel' => 'O campo "{param:3}" contém o valor "{param:1}". Os valores válidos são: {param:2}',
        'withoutLabel' => 'Este campo contém o valor "{param:1}". Os valores válidos são: {param:2}',
    ],
    RuleEnum::DATE => [
        'withLabel' => 'O campo "{param:2}" deve ser uma data no formato "{param:1}"',
        'withoutLabel' => 'Este campo deve ser uma data no formato "{param:1}"',
    ],
    RuleEnum::EMAIL => [
        'withLabel' => 'O campo "{param:1}" deve ter um endereço de email válido.',
        'withoutLabel' => 'Este campo deve ter um endereço de email válido.',
    ],
    RuleEnum::EQUALS => [
        'withLabel' => 'Os campos {param:1} e {param:2} devem ser iguais.',
        'withoutLabel' => 'Por favor introduza o mesmo valor novamente.',
    ],
    RuleEnum::FILE_MAX_SIZE => [
        'withLabel' => 'O campo "{param:3}" contém um arquivo que ocupa {param:1}. O arquivo deve ser menor que {param:2}.',
        'withoutLabel' => 'Este campo contém um arquivo que ocupa {param:1}. O arquivo deve ser menor que {param:2}.',
    ],
    RuleEnum::FILE_MIME_TYPE => [
        'withLabel' => 'O campo "{param:3}" contém um arquivo {param:1}. O tipo de arquivo deve ser {param:2}.',
        'withoutLabel' => 'Este campo contém um arquivo {param:1}. O tipo de arquivo deve ser {param:2}.',
    ],
    RuleEnum::FLOAT_NUMBER => [
        'withLabel' => 'O campo "{param:1}" deve ser um número decimal.',
        'withoutLabel' => 'Este campo deve ser um número decimal.',
    ],
    RuleEnum::IMAGE_MAX_HEIGHT => [
        'withLabel' => 'A altura da imagem enviada no campo "{param:3}" é de {param:1}px. A altura máxima permitida é de {param:2}px.',
        'withoutLabel' => 'A altura da imagem enviada neste campo é de {param:1}px. A altura máxima permitida é de {param:2}px.',
    ],
    RuleEnum::IMAGE_MAX_WIDTH => [
        'withLabel' => 'A largura da imagem enviada no campo "{param:3}" é de {param:1}px. A largura máxima permitida é de {param:2}px.',
        'withoutLabel' => 'A largura da imagem enviada neste campo é de {param:1}px. A largura máxima permitida é de {param:2}px.',
    ],
    RuleEnum::IMAGE_MIN_HEIGHT => [
        'withLabel' => 'A altura da imagem enviada no campo "{param:3}" é de {param:1}px. A altura mínima é de {param:2}px.',
        'withoutLabel' => 'A altura da imagem enviada neste campo é de {param:1}px. A altura mínima é de {param:2}px.',
    ],
    RuleEnum::IMAGE_MIN_WIDTH => [
        'withLabel' => 'A largura da imagem enviada no campo "{param:3}" é de {param:1}px. A largura mínima é de {param:2}px.',
        'withoutLabel' => 'A largura da imagem enviada neste campo é de {param:1}px. A largura mínima é de {param:2}px.',
    ],
    RuleEnum::IP => [
        'withLabel' => 'O campo "{param:1}" deve ser um endereço IP válido.',
        'withoutLabel' => 'Este campo deve ser um endereço IP válido.',
    ],
    RuleEnum::IPV4 => [
        'withLabel' => 'O campo "{param:1}" deve ser um endereço IPv4 válido.',
        'withoutLabel' => 'Este campo deve ser um endereço IPv4 válido.',
    ],
    RuleEnum::IPV6 => [
        'withLabel' => 'O campo "{param:1}" deve ser um endereço IPv6 válido.',
        'withoutLabel' => 'Este campo deve ser um endereço IPv6 válido.',
    ],
    RuleEnum::MAX => [
        'withLabel' => 'O valor do campo "{param:2}" não pode ser maior que {param:1}.',
        'withoutLabel' => 'O valor deste campo não pode ser maior que {param:1}.',
    ],
    RuleEnum::MAX_LENGTH => [
        'withLabel' => 'O campo "{param:2}" não deve exceder os {param:1} caracteres.',
        'withoutLabel' => 'Este campo não deve exceder os {param:1} caracteres.',
    ],
    RuleEnum::MIN => [
        'withLabel' => 'O valor do campo "{param:2}" deve menor que {param:1}.',
        'withoutLabel' => 'O valor deste campo deve menor que {param:1}.',
    ],
    RuleEnum::MIN_LENGTH => [
        'withLabel' => 'O campo "{param:2}" deve ter pelo menos {param:1} caracteres.',
        'withoutLabel' => 'Este campo deve ter pelo menos {param:1} caracteres.',
    ],
    RuleEnum::NUMERIC => [
        'withLabel' => 'O campo "{param:1}" deve ser numérico',
        'withoutLabel' => 'Este campo deve ser numérico',
    ],
    RuleEnum::REGEX => [
        'withLabel' => 'O campo "{param:2}" não corresponde ao padrão {param:1}',
        'withoutLabel' => 'Este campo não corresponde ao padrão {param:1}',
    ],
    RuleEnum::REQUIRED => [
        'withLabel' => 'O campo "{param:1}" é obrigatório.',
        'withoutLabel' => 'Este campo é obrigatório.',
    ],
    RuleEnum::REQUIRED_IF => [
        'withLabel' => 'O campo "{param:1}" é obrigatório.',
        'withoutLabel' => 'Este campo é obrigatório.',
    ],
    RuleEnum::REQUIRED_IF_NOT => [
        'withLabel' => 'O campo "{param:1}" é obrigatório.',
        'withoutLabel' => 'Este campo é obrigatório.',
    ],
    RuleEnum::SLUG => [
        'withLabel' => 'O campo "{param:1}" deve ser um slug válido (ex: hello-world_123).',
        'withoutLabel' => 'Este campo deve ser um slug válido (ex: hello-world_123).',
    ],
    RuleEnum::URL => [
        'withLabel' => 'O campo "{param:1}" deve ser um URL válido.',
        'withoutLabel' => 'Este campo deve ser um URL válido.',
    ],
];
