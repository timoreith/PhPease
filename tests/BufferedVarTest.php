<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class BufferedVarTest extends TestCase
{

    protected function setUp(): void
    {
    }

    public function test1()
    {
        $result = PhPease\BufferedVar::get('test-1', function () {
            return 1;
        });

        $this->assertEquals(1, $result);

        $result = PhPease\BufferedVar::get('test-1', function () {
            return 2;
        });

        // 1 is buffered under token "test-1"
        $this->assertEquals(1, $result);
    }

    public function test2()
    {
        $this->assertEquals(2, PhPease\BufferedVar::get('2', 2, 'test'));
        $this->assertEquals(2, PhPease\BufferedVar::get('2', 3, 'test'));

        // changing namespace
        $this->assertEquals(3, PhPease\BufferedVar::get('2', 3, 'test2'));
    }

}
