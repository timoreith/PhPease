<?php declare(strict_types=1);

/*
 * A simple approach to process one or more tasks one after another in a given structure with result and optional
 * exception handling. Named "Task" to distinguish it from the Command pattern.
 *
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease\Task;

use PhPease\ResultContainer;

class Manager
{
    /**
     * @var ResultContainer
     */
    protected $result;

    /**
     * @var AbstractTask[]
     */
    private $tasks = [];

    /**
     * @var int
     */
    private $tasksPerformed = 0;

    /**
     * @var bool
     */
    private $handleExceptions = true;

    /**
     * @var bool
     */
    private $stopOnFaultyResult = true;

    /**
     * @var bool
     */
    private $verbose = false;



    public function __construct()
    {
        $this->result = new ResultContainer();
    }

    /**
     * @return bool
     */
    public function hasTasks(): bool
    {
        return !empty($this->tasks);
    }

    /**
     * @return AbstractTask[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @param AbstractTask $task
     * @return $this
     */
    public function addTask(AbstractTask $task)
    {
        $this->tasks[] = $task;
        return $this;
    }

    /**
     * @param $task
     * @return void
     */
    public function run($task = null)
    {
        if ($task instanceof AbstractTask) {
            $this->addTask($task);
        }

        foreach ($this->tasks as $task) {
            $this->runTask($task);

            if ($this->runnerShouldStop()) {
                break;
            }
        }

        $this->finalize();
    }

    /**
     * @param AbstractTask $task
     * @return void
     */
    private function runTask(AbstractTask $task)
    {
        $this->incrementTaskPerformed();

        $task->setResult($this->result);

        if ($this->handleExceptions) {
            try {
                $task->preRun();
                $task->run();
                $task->postRun();
            } catch (\Exception $e) {
                $this->result->setSuccess(false)->setMessage($e->getMessage());
            }
        } else {
            $task->preRun();
            $task->run();
            $task->postRun();
        }
    }

    protected function runnerShouldStop(): bool
    {
        return $this->stopOnFaultyResult && !$this->result->isSuccess();
    }

    private function finalize()
    {
        if ($this->isVerbose()) {
            // this might help when working with the result data to realize an error has occurred
            $this->result->setData('tasks performed', $this->tasksPerformed);
        }
    }

    /**
     * @return ResultContainer
     */
    public function getResult(): ResultContainer
    {
        return $this->result;
    }

    /**
     * @param bool $handleExceptions
     */
    public function setHandleExceptions(bool $handleExceptions): void
    {
        $this->handleExceptions = $handleExceptions;
    }

    /**
     * @param bool $stopOnFaultyResult
     */
    public function setStopOnFaultyResult(bool $stopOnFaultyResult): void
    {
        $this->stopOnFaultyResult = $stopOnFaultyResult;
    }

    private function incrementTaskPerformed()
    {
        $this->tasksPerformed++;
    }

    /**
     * @return int
     */
    public function getTasksPerformed(): int
    {
        return $this->tasksPerformed;
    }

    /**
     * @return bool
     */
    public function isVerbose(): bool
    {
        return $this->verbose;
    }

    /**
     * @param bool $verbose
     */
    public function setVerbose(bool $verbose): void
    {
        $this->verbose = $verbose;
    }
}