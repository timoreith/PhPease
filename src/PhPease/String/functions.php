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


use PhPease\BufferedVar;

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

/**
 * @param $string
 * @param int $length
 * @param string $ellipsis
 * @return mixed|string
 */
function shorten($string, int $length = 25, string $ellipsis = '...') {
    return strlen($string) > $length ? substr($string, 0, $length) . $ellipsis : $string;
}

/**
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function str_ends_with(string $haystack, string $needle): bool {
    if (\PHP_VERSION_ID < 80000) {
        return $needle !== '' ? substr($haystack, -strlen($needle)) === $needle : true;
    }
    return \str_ends_with($haystack, $needle);
}

/**
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function str_starts_with(string $haystack, string $needle): bool {
    if (\PHP_VERSION_ID < 80000) {
        $length = strlen( $needle );
        return substr( $haystack, 0, $length ) === $needle;
    }
    return \str_starts_with($haystack, $needle);
}

/**
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function str_contains(string $haystack, string $needle): bool {
    if (\PHP_VERSION_ID < 80000) {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
    return \str_contains($haystack, $needle);
}

/**
 * @param string $string
 * @return array|string|string[]
 */
function to_camel_case(string $string): string {
    return str_replace(['-', '_', ' '], '', ucwords($string, '-_ '));
}

/**
 * @param string $str
 * @param $what
 * @param string $with
 * @param bool $combineRepeating
 * @return string
 */
function str_replace_all_except(string $str, $what, string $with = '_', bool $combineRepeating = true): string {
    preg_match_all($what, $str, $matches);
    if (!empty($matches[0])) {
        $str = str_replace(array_unique($matches[0]), $with, $str);

        if ($combineRepeating) {
            $str = preg_replace('~([' . $with . '])\1\1+~', '\1', $str);
        }
    }
    return (string)$str;
}

/**
 * @param string $str
 * @param string $with
 * @param bool $combineRepeating
 * @return string
 */
function str_replace_all_except_numbers(string $str, string $with = '_', bool $combineRepeating = true) {
    return str_replace_all_except($str, '/[^Z0-9]/', $with, $combineRepeating);
}

/**
 * A simple, handy function to create a random string without any claim to uniqueness.
 * Due to the intention of use for everyday non-critical tasks, with an upper character length limit of 255 characters.
 *
 * @param int $length
 * @param string|null $token If specified, the identical string is returned within the same PHP process using PhPease\BufferedVar
 * @return string
 */
function random_string(int $length = 10, string $token = null): string
{
    if (!empty($token)) {
        return BufferedVar::get($token, random_string($length));
    }

    if ($length > 255) {
        $length = 255;
    }

    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $string;
}

/**
 * @param $str
 * @return bool
 */
function is_utf8_encoded($str): bool
{
    if (function_exists('mb_check_encoding')) {
        return mb_check_encoding($str, 'UTF-8');
    }
    return preg_match('//u', $str) !== false;
}

/**
 * @param $str
 * @return mixed|string
 */
function utf8_safe_encode($str) {
    if (!is_utf8_encoded($str)) {
        if (function_exists('mb_convert_encoding')) {
            $str = mb_convert_encoding($str, 'UTF-8', 'auto');
        } elseif (function_exists('utf8_encode')) {
            $str = utf8_encode($str);
        }
    }
    return $str;
}