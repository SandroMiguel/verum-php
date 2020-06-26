<?php

/**
 * Validator messages (portuguese-Brazil).
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   1.0.0 (20/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

return [
    'alpha' => [
        'withLabel' => 'O campo "{param:1}" deve conter apenas letras (a-z).',
        'withoutLabel' => 'Este campo deve conter apenas letras (a-z).',
    ],
    'alpha_numeric' => [
        'withLabel' => 'O campo "{param:1}" deve conter apenas letras (a-z) e números (0-9).',
        'withoutLabel' => 'Este campo deve conter apenas letras (a-z) e números (0-9).',
    ],
    'between' => [
        'withLabel' => 'O campo "{param:3}" só permite valores entre {param:1} e {param:2}.',
        'withoutLabel' => 'Este campo só permite valores entre {param:1} e {param:2}.',
    ],
    'between_length' => [
        'withLabel' => 'O campo "{param:3}" deve ter entre {param:1} e {param:2} caracteres.',
        'withoutLabel' => 'Este campo deve ter entre {param:1} e {param:2} caracteres.',
    ],
    'boolean_value' => [
        'withLabel' => 'O campo "{param:1}" deve ser um valor booleano.',
        'withoutLabel' => 'Este campo deve ser um valor booleano.',
    ],
    'contains' => [
        'withLabel' => 'O campo "{param:3}" contém o valor "{param:1}". Os valores válidos são: {param:2}',
        'withoutLabel' => 'Este campo contém o valor "{param:1}". Os valores válidos são: {param:2}',
    ],
    'date' => [
        'withLabel' => 'O campo "{param:2}" deve ser uma data no formato "{param:1}"',
        'withoutLabel' => 'Este campo deve ser uma data no formato "{param:1}"',
    ],
    'email' => [
        'withLabel' => 'O campo "{param:1}" deve ter um endereço de email válido.',
        'withoutLabel' => 'Este campo deve ter um endereço de email válido.',
    ],
    'equals' => [
        'withLabel' => 'Os campos {param:1} e {param:2} devem ser iguais.',
        'withoutLabel' => 'Por favor introduza o mesmo valor novamente.',
    ],
    'file_max_size' => [
        'withLabel' => 'O campo "{param:3}" contém um arquivo que ocupa {param:1}. O arquivo deve ser menor que {param:2}.',
        'withoutLabel' => 'Este campo contém um arquivo que ocupa {param:1}. O arquivo deve ser menor que {param:2}.',
    ],
    'file_mime_type' => [
        'withLabel' => 'O campo "{param:3}" contém um arquivo {param:1}. O tipo de arquivo deve ser {param:2}.',
        'withoutLabel' => 'Este campo contém um arquivo {param:1}. O tipo de arquivo deve ser {param:2}.',
    ],
    'float_number' => [
        'withLabel' => 'O campo "{param:1}" deve ser um número decimal.',
        'withoutLabel' => 'Este campo deve ser um número decimal.',
    ],
    'image_max_height' => [
        'withLabel' => 'A altura da imagem enviada no campo "{param:3}" é de {param:1}px. A altura máxima permitida é de {param:2}px.',
        'withoutLabel' => 'A altura da imagem enviada neste campo é de {param:1}px. A altura máxima permitida é de {param:2}px.',
    ],
    'image_max_width' => [
        'withLabel' => 'A largura da imagem enviada no campo "{param:3}" é de {param:1}px. A largura máxima permitida é de {param:2}px.',
        'withoutLabel' => 'A largura da imagem enviada neste campo é de {param:1}px. A largura máxima permitida é de {param:2}px.',
    ],
    'image_min_height' => [
        'withLabel' => 'A altura da imagem enviada no campo "{param:3}" é de {param:1}px. A altura mínima é de {param:2}px.',
        'withoutLabel' => 'A altura da imagem enviada neste campo é de {param:1}px. A altura mínima é de {param:2}px.',
    ],
    'image_min_width' => [
        'withLabel' => 'A largura da imagem enviada no campo "{param:3}" é de {param:1}px. A largura mínima é de {param:2}px.',
        'withoutLabel' => 'A largura da imagem enviada neste campo é de {param:1}px. A largura mínima é de {param:2}px.',
    ],
    'ip' => [
        'withLabel' => 'O campo "{param:1}" deve ser um endereço IP válido.',
        'withoutLabel' => 'Este campo deve ser um endereço IP válido.',
    ],
    'ipv4' => [
        'withLabel' => 'O campo "{param:1}" deve ser um endereço IPv4 válido.',
        'withoutLabel' => 'Este campo deve ser um endereço IPv4 válido.',
    ],
    'ipv6' => [
        'withLabel' => 'O campo "{param:1}" deve ser um endereço IPv6 válido.',
        'withoutLabel' => 'Este campo deve ser um endereço IPv6 válido.',
    ],
    'max' => [
        'withLabel' => 'O valor do campo "{param:2}" não pode ser maior que {param:1}.',
        'withoutLabel' => 'O valor deste campo não pode ser maior que {param:1}.',
    ],
    'max_length' => [
        'withLabel' => 'O campo "{param:2}" não deve exceder os {param:1} caracteres.',
        'withoutLabel' => 'Este campo não deve exceder os {param:1} caracteres.',
    ],
    'min' => [
        'withLabel' => 'O valor do campo "{param:2}" deve menor que {param:1}.',
        'withoutLabel' => 'O valor deste campo deve menor que {param:1}.',
    ],
    'min_length' => [
        'withLabel' => 'O campo "{param:2}" deve ter pelo menos {param:1} caracteres.',
        'withoutLabel' => 'Este campo deve ter pelo menos {param:1} caracteres.',
    ],
    'numeric' => [
        'withLabel' => 'O campo "{param:1}" deve ser numérico',
        'withoutLabel' => 'Este campo deve ser numérico',
    ],
    'regex' => [
        'withLabel' => 'O campo "{param:2}" não corresponde ao padrão {param:1}.',
        'withoutLabel' => 'Este campo não corresponde ao padrão {param:1}.',
    ],
    'required' => [
        'withLabel' => 'O campo "{param:1}" é obrigatório.',
        'withoutLabel' => 'Este campo é obrigatório.',
    ],
    'slug' => [
        'withLabel' => 'O campo "{param:1}" deve ser um slug válido (ex: hello-world_123).',
        'withoutLabel' => 'Este campo deve ser um slug válido (ex: hello-world_123).',
    ],
    'url' => [
        'withLabel' => 'O campo "{param:1}" deve ser um URL válido.',
        'withoutLabel' => 'Este campo deve ser um URL válido.',
    ],
];
