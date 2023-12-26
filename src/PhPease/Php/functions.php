<?php declare(strict_types=1);

/*
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease\Php;

use function PhPease\Convert\bytes_to_human_readable;

/**
 * @return float|int
 */
function get_file_upload_max_size() {

    static $max_size = -1;

    if ($max_size < 0) {
        // Start with post_max_size.
        $post_max_size = parse_ini_filesize(ini_get('post_max_size'));

        if ($post_max_size > 0) {
            $max_size = $post_max_size;
        }

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $upload_max = parse_ini_filesize(ini_get('upload_max_filesize'));

        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }
    }

    return $max_size;
}

function get_file_upload_max_size_human_readable(): string
{
    return bytes_to_human_readable(get_file_upload_max_size());
}

/**
 * helper function to work with file sizes in ini file format
 * @param $size
 * @return float
 */
function parse_ini_filesize($size): float
{
    // Remove the non-unit characters from the size.
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
    // Remove the non-numeric characters from the size.
    $size = (float)preg_replace('/[^0-9\.]/', '', $size);

    if ($unit) {
        // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
        return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    } else {
        return round($size);
    }
}

/**
 * get memory limit in kilobytes
 * @return false|float|int|string
 */
function get_memory_limit() {
    $memory_limit = ini_get('memory_limit');
    if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
        if ($matches[2] == 'M') {
            $memory_limit = $matches[1] * 1024; // nnnM -> nnn MB
        } else if ($matches[2] == 'K') {
            $memory_limit = $matches[1]; // nnnK -> nnn KB
        } else if ($matches[2] == 'G') {
            $memory_limit = $matches[1] * 1024 * 1024; // nnnG -> nnn GB
        }
    }
    return $memory_limit;
}

/**
 * get remaining memory in kilobytes
 * @return float|int
 */
function get_remaining_memory()
{
    $current_memory_usage = memory_get_usage(); // in bytes
    $remaining_memory = get_memory_limit() * 1024 - $current_memory_usage; // in bytes

    // convert remaining memory from bytes to kilobytes
    return $remaining_memory / 1024;
}