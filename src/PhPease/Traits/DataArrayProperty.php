<?php
declare(strict_types=1);

/*
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease\Traits;

trait DataArrayProperty
{
    /**
     * @var \ArrayObject
     */
    private $data;


    /**
     * @param array $data
     * @return \ArrayObject
     */
    private function initData(array $data = []): \ArrayObject
    {
        if (!($this->data instanceof \ArrayObject) || !empty($data)) {
            $this->data = new \ArrayObject($data);
        }
        return $this->data;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setData($key, $value)
    {
        $this->initData()->offsetSet($key, $value);
    }

    /**
     * @param $key
     */
    public function unsetData($key)
    {
        $this->initData()->offsetUnset($key);
    }

    public function resetData()
    {
        $this->exchangeData([]);
    }

    /**
     * @param array|object $array
     * @return array
     */
    public function exchangeData($array)
    {
        return $this->initData()->exchangeArray($array);
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasData($key)
    {
        return $this->initData()->offsetExists($key);
    }

    /**
     * @param $key
     * @return false|mixed
     */
    public function getData($key)
    {
        return $this->initData()->offsetGet($key);
    }

    /**
     * @return array
     */
    public function getAllData(): array
    {
        return $this->initData()->getArrayCopy();
    }

    /**
     * @return int
     */
    public function countData()
    {
        return $this->initData()->count();
    }
}