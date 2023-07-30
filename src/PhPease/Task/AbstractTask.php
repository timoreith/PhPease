<?php

namespace PhPease\Task;

use PhPease\ResultContainer;

abstract class AbstractTask
{
    /**
     * @var ResultContainer
     */
    protected $result;

    /**
     * @param ResultContainer $result
     */
    public function setResult(ResultContainer $result): void
    {
        $this->result = $result;
    }

    public function preRun()
    {
    }

    public abstract function run();

    public function postRun()
    {
    }
}