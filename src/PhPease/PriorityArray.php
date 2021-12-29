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

class PriorityArray
{
    /**
     * @var array
     */
    private $elements = [];


    /**
     * @param $element
     * @param int $priority
     * @return PriorityArray
     */
    public function add($element, int $priority = 10)
    {
        array_push($this->elements,
            [
                'prio' => $priority,
                'el' => $element
            ]
        );

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $result = [];
        $priority = [];

        foreach ($this->elements as $key => $row) {
            $priority[$key]  = $row['prio'];
        }

        array_multisort($priority, SORT_ASC, $this->elements);

        foreach ($this->elements as $k => $v) {
            array_push($result, $v['el']);
        }

        return $result;
    }
}