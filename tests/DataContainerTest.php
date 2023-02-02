<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class DataContainerTest extends TestCase
{
    protected function setUp(): void
    {
    }

    public function testAddData()
    {
        $data = new \PhPease\Data\Container();
        $this->assertFalse($data->hasData(), 'data has data');
        $data->addData('message 1');
        $this->assertTrue($data->hasData(), 'data has no data');
        $data->addData('message 2');
        $this->assertEquals(2, $data->countData(), 'data has not 2 data');

        $result = $data->getAllData();
        $this->assertEquals('message 1', $result[0], 'message 1 not as expected');
        $this->assertEquals('message 2', $result[1], 'message 1 not as expected');
        $this->assertIsString($data->getAllDataJsonEncoded(), 'result is not a string');

        $data->resetData();
        $this->assertCount(0, $data->getAllData(), 'data is not empty');

    }

    public function testSetData()
    {
        $data = new \PhPease\Data\Container();

        $data->setData('key1', 'message 1');
        $this->assertTrue($data->hasData('key1'), 'data has no data');

    }

}
