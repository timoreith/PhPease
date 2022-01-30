<?php declare(strict_types=1);

/**
 * Helper for manual autoloading
 *
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease\Helper;

const ROOT_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

/**
 * @param $className
 * @return bool
 */
function autoload($className)
{
    $result = false;

    if (strpos($className, 'PhPease') === 0) {
        $classPath = ROOT_DIR . str_replace('\\', DIRECTORY_SEPARATOR, substr($className, 8)) . '.php';

        if (file_exists($classPath)) {
            include_once $classPath;
            $result = true;
        }
    }

    return $result;
}

spl_autoload_register('\PhPease\Helper\autoload');

require_once ROOT_DIR . 'functions_include.php';