<?php declare(strict_types=1);

/*
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease\Variable;

/**
 * @param $var
 * @return bool
 */
function is_stricly_true($var): bool
{
    return $var === true;
}

/**
 * @param $var
 * @return bool
 */
function is_true($var): bool
{
    if (is_stricly_true($var) || !empty($var)) {
        return true;
    }
    return false;
}

/**
 * @param $var
 * @return bool
 */
function is_stricly_false($var): bool
{
    return $var === false;
}

/**
 * @param $var
 * @return bool
 */
function is_false($var): bool
{
    if (is_stricly_false($var) || empty($var) || $var === 'false') {
        return true;
    }
    return false;
}

/**
 * @param mixed $scalar
 * @param array $valid
 * @param null $default
 * @param bool $strict
 * @return mixed|null
 */
function filter_scalar($scalar, array $valid, $default = null, $strict = true)
{
    $result = $default;
    if (in_array($scalar, $valid, $strict)) {
        $result = $scalar;
    }
    return $result;
}

/**
 * Ensures that the return value is an array. Converts variables that are not arrays and not empty into arrays.
 * A callback can be specified to be applied to the elements of the array.
 *
 * @param $var
 * @param null|array|callable $callback
 * @return array
 */
function var_to_array($var, $callback = null, array $emptyDefault = []): array
{
    if (!is_array($var)) {
        if (empty($var)) {
            $var = $emptyDefault;
        } else {
            if (is_string($var) && strpos($var, ',') !== false) {
                $var = array_map('trim', explode(',', $var));
                $var = array_filter($var, function ($v) {
                    return $v !== '';
                });
            } else {
                $var = array($var);
            }
        }
    }
    if (is_callable($callback)) {
        $var = array_map($callback, $var);
    } elseif (is_array($callback)) {
        foreach ($callback as $cb) {
            if (is_callable($cb)) {
                $var = array_map($cb, $var);
            }
        }
    }
    return $var;
}

/**
 * Checks if all keys of array $keys exist in array $arr
 *
 * @param array $keys
 * @param array $arr
 * @return bool
 */
function array_keys_exists(array $keys, array $arr): bool
{
    return !array_diff_key(array_flip($keys), $arr);
}

/**
 * @param $var
 * @param int $decimals
 * @return float
 */
function var_to_float($var, int $decimals = 2): float
{
    if (empty($var) && !is_numeric($var)) {
        return 0.0;
    }
    
    $var = (string)$var;
    
    // Remove all non-numeric characters except dots and commas
    $var = preg_replace('/[^0-9\.,]/', '', $var);
    
    // Check for thousand separator pattern (e.g., 1,000,000)
    if (preg_match('/^\d{1,3}(,\d{3})+$/', $var)) {
        // This is a number with thousand separators only
        return round((float)str_replace(',', '', $var), $decimals);
    }
    
    // Handle different number formats
    
    // If there's a dot in the string
    if (strpos($var, '.') !== false) {
        // If there are multiple dots, keep only the last one
        if (substr_count($var, '.') > 1) {
            $parts = explode('.', $var);
            $last = array_pop($parts);
            $var = implode('', $parts) . '.' . $last;
        }
        
        // Remove all commas (assuming they are thousand separators)
        $var = str_replace(',', '', $var);
    } 
    // If there's no dot but there are commas
    else if (strpos($var, ',') !== false) {
        // Check for thousand separator pattern (e.g., 1,234)
        if (preg_match('/\d{1,3}(,\d{3})+$/', $var)) {
            // This is a number with thousand separators
            $var = str_replace(',', '', $var);
        } else {
            // If there are multiple commas, treat all but the last as thousand separators
            if (substr_count($var, ',') > 1) {
                $parts = explode(',', $var);
                $last = array_pop($parts);
                $var = implode('', $parts) . '.' . $last;
            } else {
                // Single comma is treated as decimal separator
                $var = str_replace(',', '.', $var);
            }
        }
    }
    
    return round((float)$var, $decimals);
}

/**
 * get size of array in bytes
 * @param array $array
 * @return int
 */
function get_array_size(array $array): int
{
    $serializedArray = serialize($array);

    if (function_exists('mb_strlen')) {
        $sizeInBytes = mb_strlen($serializedArray, '8bit');
    } else {
        $sizeInBytes = strlen($serializedArray);
    }

    return $sizeInBytes;
}