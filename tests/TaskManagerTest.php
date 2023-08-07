<?php declare(strict_types=1);

use PhPease\Task\AbstractTask;
use PHPUnit\Framework\TestCase;
use function PhPease\Variable\var_to_array;

final class TaskManagerTest extends TestCase
{
    protected function setUp(): void
    {
    }

    public function testDefaults()
    {
        $tm = new \PhPease\Task\Manager();

        $this->assertTrue($tm->getResult()->isSuccess());
        $this->assertEquals('', $tm->getResult()->getMessage());

        $tm->getResult()->setSuccess(false);
        $this->assertFalse($tm->getResult()->isSuccess());

        $tm->getResult()->setMessage('test123');
        $this->assertNotEquals('', $tm->getResult()->getMessage());
        $this->assertEquals('test123', $tm->getResult()->getMessage());
    }

    public function testRunTaskOne()
    {
        $tm = new \PhPease\Task\Manager();

        $task1 = new TaskOne();

        $tm->run($task1);


        $this->assertTrue($tm->getResult()->hasData('html'));
        $this->assertEquals('<p>Test One</p>', $tm->getResult()->getData('html'));
    }

    public function testMultiTasks()
    {
        $tm = new \PhPease\Task\Manager();

        $task1 = new TaskOne();
        $task2 = new TaskTwo();

        $tm->addTask($task1)->addTask($task2)->run();

        $this->assertTrue($tm->getResult()->hasData('html'));
        $this->assertEquals('<p>Test Two</p>', $tm->getResult()->getData('html'));

        $this->assertTrue($tm->getResult()->hasData('list'));
        $this->assertCount(2, $tm->getResult()->getData('list') );
    }

    public function testMultiTasksWithException()
    {
        $tm = new \PhPease\Task\Manager();
        $tm->setVerbose(true);

        $task1 = new TaskOne();
        $task2 = new TaskTwo();
        $taskE = new TaskThrowsException();

        $tm->addTask($task1)->addTask($taskE)->addTask($task2)->run();

        $this->assertCount(3, $tm->getTasks() );

        $this->assertTrue($tm->getResult()->hasData('html'));
        $this->assertEquals('<p>Test One</p>', $tm->getResult()->getData('html'));

        $this->assertTrue($tm->getResult()->hasData('list'));
        $this->assertCount(1, $tm->getResult()->getData('list') );

        $this->assertFalse($tm->getResult()->isSuccess());
        $this->assertEquals('something went wrong in TaskThrowsException', $tm->getResult()->getMessage());

        $this->assertTrue($tm->getResult()->hasData('tasks performed'));
        $this->assertEquals(2, $tm->getTasksPerformed());
    }

    public function testSetTasks()
    {
        $tm = new \PhPease\Task\Manager();

        $tm->setTasks([
            new TaskOne(),
            new TaskTwo(),
            new stdClass(),
            'no valid task'
        ]);

        $this->assertTrue($tm->hasTasks());
        $this->assertCount(2, $tm->getTasks() );
    }
}

if (!class_exists('PhPease\Task\AbstractTask')) {
    require_once __DIR__ . '/../src/PhPease/Task/AbstractTask.php';
}

class TaskOne extends AbstractTask {
    public function run()
    {
        $this->result->setData('html', '<p>Test One</p>');

        $list = var_to_array( $this->result->getData('list') );
        $list[] = 'test one';
        $this->result->setData('list', $list);
    }
}
class TaskTwo extends AbstractTask {
    public function run()
    {
        $this->result->setData('html', '<p>Test Two</p>');

        $list = var_to_array( $this->result->getData('list') );
        $list[] = 'test two';
        $this->result->setData('list', $list);
    }
}

class TaskThrowsException extends AbstractTask {
    public function run()
    {
        throw new \Exception('something went wrong in TaskThrowsException');
    }
}