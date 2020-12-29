<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\Variable\is_stricly_true;
use function PhPease\Variable\is_true;

final class VaribaleTest extends TestCase
{
    public function testIsStriclyTrue()
    {
        $this->assertFalse(is_stricly_true(1));
        $this->assertFalse(is_stricly_true("1"));
        $this->assertFalse(is_stricly_true("bla"));
        $this->assertFalse(is_stricly_true("true"));
        $this->assertTrue(is_stricly_true(true));
    }

    public function testIsTrue()
    {
        $this->assertTrue(is_true(1));
        $this->assertTrue(is_true("1"));
        $this->assertTrue(is_true("bla"));
        $this->assertTrue(is_true("true"));
        $this->assertTrue(is_true(true));
        $this->assertFalse(is_true(0));
        $this->assertFalse(is_true('0'));
    }
}
