<?php declare(strict_types=1);

/*
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease\String;


function filter_string($string, $mode='alphanum') {
    switch ($mode) {
        case 'filename':
            $string = str_replace(' ', '_', $string);
            $string = replace_umlauts($string);
            $string = preg_replace('/[^\.A-Za-z0-9_-]/', '', $string);
            break;
        case 'alphanum-whitespace':
            $string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
            break;
        case 'alphanum-underscore-minus':
            $string = preg_replace("/[^A-Za-z0-9_-]/", '', $string);
            break;
        default:
            $string = preg_replace("/[^A-Za-z0-9]/", '', $string);
    }
    return $string;
}

/**
 * @param $string
 * @return string|string[]|null
 */
function filter_filename($string) {
    return filter_string($string, 'filename');
}

/**
 * @param $string
 * @return string|string[]|null
 */
function filter_string_allow_underscore_minus($string) {
    return filter_string($string, 'alphanum-underscore-minus');
}

/**
 * @param $string
 * @return mixed
 */
function filter_numeric($string) {
    return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * @param $string
 * @return string
 */
function replace_umlauts($string) {
    return strtr($string, [
        'ä' => 'ae',
        'Ä' => 'Ae',
        'ö' => 'oe',
        'Ö' => 'Oe',
        'ü' => 'ue',
        'Ü' => 'Ue',
        'ß' => 'ss',
        'é' => 'e',
        'á' => 'a',
        'ó' => 'o',
    ]);
}