<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\Conf\get_memory_limit;
use function PhPease\Convert\kilobytes_to_human_readable;

final class ConfTest extends TestCase
{
    public function test_get_memory_limit_128M()
    {
        ini_set('memory_limit', '128M');

        $memLimit = get_memory_limit();

        $this->assertEquals(131072, $memLimit);
        $this->assertEquals('128.00 MB', kilobytes_to_human_readable($memLimit));
    }

    public function test_get_memory_limit_64M()
    {
        ini_set('memory_limit', '64M');

        $memLimit = get_memory_limit();

        $this->assertEquals(65536, $memLimit);
        $this->assertEquals('64.00 MB', kilobytes_to_human_readable($memLimit));
    }
}
