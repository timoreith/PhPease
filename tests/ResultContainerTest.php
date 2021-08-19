<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class ResultContainerTest extends TestCase
{
    protected function setUp(): void
    {
    }

    public function testDefaultSuccess()
    {
        $result = new \PhPease\ResultContainer();
        $this->assertTrue($result->isSuccess(), 'default result is not true');
    }

    public function testChangeSuccess()
    {
        $result = new \PhPease\ResultContainer();
        $result->setSuccess(false);
        $this->assertFalse($result->isSuccess(), 'success was not set to false');
        $result->setSuccess(true);
        $this->assertTrue($result->isSuccess(), 'success was not set to true again');
    }

    public function testInitValues()
    {
        $initMsg = 'testing default false';
        $result = new \PhPease\ResultContainer(false, $initMsg);
        $this->assertFalse($result->isSuccess(), 'success was not set to false');
        $this->assertEquals($result->getMessage(), $initMsg, 'init message was not set');
    }

    public function testChangeMessage()
    {
        $result = new \PhPease\ResultContainer();
        $this->assertEquals($result->getMessage(), '', 'init message is not empty');
        $newMsg = 'data saved successfully';
        $result->setMessage($newMsg);
        $this->assertEquals($result->getMessage(), $newMsg, 'new message was not set');
    }

    public function testData()
    {
        $result = new \PhPease\ResultContainer();

        $v1 = 'value1';
        $result->setData('key1', $v1);
        $this->assertEquals($result->getData('key1'), $v1);
        $this->assertIsString($result->getData('key1'));

        $v2 = 123;
        $result->setData('key2', $v2);
        $this->assertEquals($result->getData('key2'), $v2);
        $this->assertIsInt($result->getData('key2'));
        $this->assertTrue($result->hasData('key2'));
        $this->assertFalse($result->hasData('key3'));

        $this->assertCount(2, $result->getAllData());
        $this->assertEquals($result->countData(), 2);

        $result->unsetData('key2');
        $this->assertFalse($result->hasData('key2'));

        $result->resetData();
        $this->assertCount(0, $result->getAllData());

        $result->exchangeData([
            'key4' => 'v4',
            'key5' => 'v5',
            'key6' => 'v6',
        ]);
        $this->assertCount(3, $result->getAllData());
        $this->assertEquals($result->getData('key5'), 'v5');
    }

}
