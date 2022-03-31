<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\String\str_contains;
use function PhPease\String\str_ends_with;
use function PhPease\String\str_starts_with;
use function PhPease\Variable\is_stricly_true;
use function PhPease\Variable\is_true;
use function PhPease\Variable\is_stricly_false;
use function PhPease\Variable\is_false;
use function PhPease\Variable\var_to_array;

final class StringTest extends TestCase
{
    public function testStrEndsWith()
    {
        $this->assertFalse(str_ends_with('abcdefg', 'f'));
        $this->assertTrue(str_ends_with('abcdefg', 'fg'));
        $this->assertTrue(str_ends_with('abcdefg', 'abcdefg'));
        $this->assertFalse(str_ends_with('abcdefg', 'abc'));
        $this->assertTrue(str_ends_with('abcdefg ', ' '));
        $this->assertTrue(str_ends_with('', ''));
        $this->assertFalse(str_ends_with('', ' '));
    }

    public function testStrStartsWith()
    {
        $this->assertTrue(str_starts_with('abcdefg', 'a'));
        $this->assertFalse(str_starts_with('abcdefg', 'g'));
        $this->assertTrue(str_starts_with('abcdefg', 'abcdefg'));
        $this->assertTrue(str_starts_with('abcdefg', ''));
        $this->assertFalse(str_starts_with('abcdefg', ' '));
        $this->assertTrue(str_starts_with('', ''));
        $this->assertFalse(str_starts_with('', ' '));
    }

    public function testStrContains()
    {
        $this->assertTrue(str_contains('abcdefg', 'cd'));
        $this->assertFalse(str_contains('abcdefg', 'cdf'));
        $this->assertFalse(str_contains('abcdefg', ' '));
        $this->assertTrue(str_contains('abcdefg', ''));
        $this->assertTrue(str_contains('abcd123efg', '2'));
    }
}