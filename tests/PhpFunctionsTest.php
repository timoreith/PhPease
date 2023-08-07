<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
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
}
