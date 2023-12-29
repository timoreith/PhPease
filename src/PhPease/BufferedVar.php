<?php declare(strict_types=1);

/*
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease;


class BufferedVar
{
    /**
     * @var array
     */
    protected static array $_buffer = [];

    /**
     * @param $token string unique token
     * @param $callable mixed function or variable to be buffered
     * @param string $ns buffer namespace
     * @return mixed
     */
    public static function get(string $token, $callable, string $ns = 'default')
    {
        if (!self::exists($token, $ns)) {
            if (is_callable($callable)) {
                self::$_buffer[$ns][$token] = call_user_func($callable);
            } else {
                self::$_buffer[$ns][$token] = $callable;
            }
        }

        return self::$_buffer[$ns][$token];
    }

    /**
     * @param $token
     * @param string $ns
     * @return bool
     */
    public static function exists($token, string $ns = 'default'): bool
    {
        if (!isset(self::$_buffer[$ns])) {
            self::$_buffer[$ns] = [];
        }
        return isset(self::$_buffer[$ns]) && array_key_exists($token, self::$_buffer[$ns]);
    }
}


