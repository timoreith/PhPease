<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\Convert\kilobytes_to_human_readable;
use function PhPease\Php\get_remaining_memory;
use function PhPease\Php\get_memory_limit;
use function PhPease\Php\parse_ini_filesize;

final class PhpFunctionsTest extends TestCase
{
    public function testParseIniFilesize()
    {
        $this->assertEquals(2097152, parse_ini_filesize('2M'));
        $this->assertEquals(4194304, parse_ini_filesize('4M'));
        $this->assertEquals(536870912, parse_ini_filesize('512 M'));
        $this->assertEquals(2147483648, parse_ini_filesize('2G'));
        $this->assertEquals(400, parse_ini_filesize('400'));
    }

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
    }}
