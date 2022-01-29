<?php declare(strict_types=1);

namespace PhPease;

/**
 * @credits https://gist.github.com/chuckreynolds/c93791dc8179288a7d08c29f31bf1080
 */
class StopWatch
{
    /**
     * @var $startTimes array The start times of the StopWatches
     */
    private static $startTimes = [];

    /**
     * Start the timer
     *
     * @param $timerName string The name of the timer
     * @return void
     */
    public static function start(string $timerName = 'default') {
        self::$startTimes[$timerName] = microtime(true);
    }

    /**
     * Get the elapsed time in seconds
     *
     * @param $timerName string The name of the timer to start
     * @return float The elapsed time since start() was called
     */
    public static function elapsed(string $timerName = 'default') {
        return microtime(true) - self::$startTimes[$timerName];
    }
}