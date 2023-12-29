<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\String\random_string;
use function PhPease\String\str_contains;
use function PhPease\String\str_ends_with;
use function PhPease\String\str_replace_all_except_numbers;
use function PhPease\String\str_starts_with;
use function PhPease\String\to_camel_case;
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

    public function testStrToCamelCase()
    {
        $this->assertEquals('ThisIsAString', to_camel_case('this-is-a_ string'));
        $this->assertEquals('ThisClassName', to_camel_case('this-class-name'));
        $this->assertEquals('ThatClassName', to_camel_case('That-Class_Name'));
        $this->assertEquals('aMethodName', lcfirst( to_camel_case('a method name') ));
    }

    public function testStrReplaceAllExceptNumbers()
    {
        $this->assertEquals('20_08_2012_20_13_33', str_replace_all_except_numbers('20.08.2012 20:13:33'));
        $this->assertEquals('20_08_2012_20_13_33', str_replace_all_except_numbers('20.08.2012 - 20:13:33'));
        $this->assertEquals('20-08-2012-20-13-33', str_replace_all_except_numbers('20.08.2012 - 20:13:33', '-'));
        $this->assertEquals('20-08-2012---20-13-33', str_replace_all_except_numbers('20.08.2012 - 20:13:33', '-', false));
    }

    public function testRandomString()
    {
        $this->assertEquals(10, strlen(random_string()));
        $this->assertEquals(32, strlen(random_string(32)));
        $this->assertEquals(16, strlen(random_string(16)));
        $this->assertEquals(8, strlen(random_string(8)));
        $this->assertEquals(4, strlen(random_string(4)));
        $this->assertEquals(2, strlen(random_string(2)));
        $this->assertEquals(1, strlen(random_string(1)));
        $this->assertEquals(0, strlen(random_string(0)));
        $this->assertEquals('', random_string(0));
        $this->assertEquals(0, strlen(random_string(-1)));
        $this->assertEquals(255, strlen(random_string(PHP_INT_MAX)));
        $this->assertEquals(0, strlen(random_string(PHP_INT_MIN)));

        $this->expectException(\TypeError::class);
        $this->assertEquals(255, strlen(random_string(PHP_INT_MAX + 1)));

        $this->expectException(\TypeError::class);
        $this->assertEquals(0, strlen(random_string(PHP_INT_MIN - 1)));
    }
}
