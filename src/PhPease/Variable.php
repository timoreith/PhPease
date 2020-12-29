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


class Variable
{
    private $var;

    public function __construct($var)
    {
        $this->var = $var;
    }

    public function isStriclyTrue() {
        return Variable\is_stricly_true($this->var);
    }

    public function isTrue() {
        return Variable\is_true($this->var);
    }
}


