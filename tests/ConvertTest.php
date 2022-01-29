<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\Convert\bytes_to_human_readable;

final class ConvertTest extends TestCase
{
    public function test_bytes_to_human_readable()
    {
        $this->assertEquals('11.77 MB', bytes_to_human_readable(12345678));
        $this->assertEquals('0.00 B', bytes_to_human_readable(0));
        $this->assertEquals('3.32 GB', bytes_to_human_readable(3567362450));
        $this->assertEquals('239.50 kB', bytes_to_human_readable(245244));
    }
}
