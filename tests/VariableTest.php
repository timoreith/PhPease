<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\Variable\is_stricly_true;
use function PhPease\Variable\is_true;
use function PhPease\Variable\is_stricly_false;
use function PhPease\Variable\is_false;
use function PhPease\Variable\var_to_array;
use function PhPease\Variable\array_keys_exists;

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

    public function testCommaSeparatedStringToArrayTrim()
    {
        $var = var_to_array('1, 2, 3');
        $this->assertIsArray($var);
        $this->assertCount(3, $var);
        $this->assertEquals('2', $var[1], 'value did not get trimmed');

        // Empty characters at the end of a comma-separated list should be filtered out
        $var2 = var_to_array('1, 2,');
        $this->assertIsArray($var2);
        $this->assertCount(2, $var2);
        $this->assertEquals('2', $var2[1], 'value did not get trimmed');
    }

    public function testEmptyStringToArray()
    {
        $var = var_to_array('');
        $this->assertIsArray($var);
        $this->assertCount(0, $var);
        $this->assertEmpty($var, 'var is not empty');
    }

    public function testZeroToArray()
    {
        $var = var_to_array('0');
        $this->assertIsArray($var);
        $this->assertCount(0, $var);
        $this->assertEmpty($var, 'var is not empty');

        $var = var_to_array('0', null, ['0']);
        $this->assertIsArray($var);
        $this->assertCount(1, $var);
        $this->assertIsString($var[0]);
        $this->assertEquals('0', $var[0]);
    }

    public function testStringToArray()
    {
        $var = var_to_array('dummy');
        $this->assertIsArray($var);
        $this->assertCount(1, $var);
        $this->assertEquals('dummy', $var[0]);
    }

    public function testToArrayWithMultiCallback()
    {
        $var = '1, 2, 3 , 4 ';

        $var = var_to_array($var, ['intval', function ($v) {
            return $v*2;
        }]);

        $this->assertIsArray($var);
        $this->assertCount(4, $var);
        $this->assertEquals(2, $var[0]);
        $this->assertEquals(4, $var[1]);
        $this->assertEquals(6, $var[2]);
        $this->assertEquals(8, $var[3]);
    }

    public function testArrayKeysExists()
    {
        $required = ['item_number', 'url', 'title'];

        $data = [
            'item_number' => 123,
            'url' => 'http://test.com',
            'test' => 'dummy'
        ];

        $this->assertFalse(array_keys_exists($required, $data));

        $data['title'] = 'item title';

        $this->assertTrue(array_keys_exists($required, $data));
    }

    public function testGetArraySize()
    {
        $a1 = [
            'k1' => '123'
        ];

        var_dump( \PhPease\Variable\get_array_size($a1));
    }
}
