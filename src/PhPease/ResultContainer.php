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

use PhPease\Traits\DataArrayProperty;

class ResultContainer
{
    use DataArrayProperty;

    /**
     * @var bool
     */
    protected $_success = true;

    /**
     * @var string
     */
    protected $_message = '';



    /**
     * @param bool $success
     * @param string $message
     * @param array $data
     */
    public function __construct(bool $success = true, string $message = '', array $data = [])
    {
        $this->_success = $success;
        $this->_message = $message;
        $this->initData($data);
    }

    /**
     * @return boolean
     */
    public function isSuccess(): bool
    {
        return $this->_success;
    }

    /**
     * @param boolean $success
     * @return ResultContainer
     */
    public function setSuccess(bool $success): ResultContainer
    {
        $this->_success = $success;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasMessage(): bool
    {
        return !empty($this->_message);
    }

    /**
     * @return null|string
     */
    public function getMessage(): string
    {
        return $this->_message;
    }

    /**
     * @param string $message
     * @return ResultContainer
     */
    public function setMessage(string $message): ResultContainer
    {
        $this->_message = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'success' => $this->isSuccess(),
            'message' => $this->getMessage(),
            'data' => $this->getAllData()
        ];
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
