<?php declare(strict_types=1);

/*
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease\Conf;

/**
 * get memory limit in kilobyte
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