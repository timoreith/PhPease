<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\Variable\is_stricly_true;
use function PhPease\Variable\is_true;
use function PhPease\Variable\is_stricly_false;
use function PhPease\Variable\is_false;
use function PhPease\Variable\var_to_array;

final class VariableTest extends TestCase
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

    public function testIsStriclyFalse()
    {
        $this->assertFalse(is_stricly_false(0));
        $this->assertFalse(is_stricly_false("0"));
        $this->assertFalse(is_stricly_false(-1));
        $this->assertFalse(is_stricly_false("bla"));
        $this->assertFalse(is_stricly_false(" "));
        $this->assertFalse(is_stricly_false("false"));
        $this->assertTrue(is_stricly_false(false));
    }

    public function testIsFalse()
    {
        $this->assertTrue(is_false(0));
        $this->assertTrue(is_false("0"));
        $this->assertTrue(is_false("false"));
        $this->assertFalse(is_false("fault"));
        $this->assertFalse(is_false("true"));
        $this->assertTrue(is_false(false));
    }

    public function testCommaSeparatedStringToArray()
    {
        $var = var_to_array('1,2,3', 'intval');
        $this->assertIsArray($var);
        $this->assertCount(3, $var);
        $this->assertIsInt($var[0]);
    }

    public function testEmptyStringToArray()
    {
        $var = var_to_array('');
        $this->assertIsArray($var);
        $this->assertCount(0, $var);
    }

    public function testStringToArray()
    {
        $var = var_to_array('dummy');
        $this->assertIsArray($var);
        $this->assertCount(1, $var);
        $this->assertEquals('dummy', $var[0]);
    }
}
