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