<?php declare(strict_types=1);

/*
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease\Convert;

/**
 * @see https://www.codexworld.com/how-to/convert-file-size-to-human-readable-format-php/
 *
 * @param $bytes
 * @param int $decimals
 * @return string
 */
function bytes_to_human_readable($bytes, int $decimals = 2): string
{
    if (is_numeric($bytes)) {
        $bytes = strval($bytes);
    }
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
}

/**
 * @param $kilobytes
 * @param int $decimals
 * @return string
 */
function kilobytes_to_human_readable($kilobytes, int $decimals = 2): string
{
    return bytes_to_human_readable($kilobytes*1024, $decimals);
}
