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