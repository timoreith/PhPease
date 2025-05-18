<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use function PhPease\Variable\is_stricly_true;
use function PhPease\Variable\is_true;
use function PhPease\Variable\is_stricly_false;
use function PhPease\Variable\is_false;
use function PhPease\Variable\var_to_array;
use function PhPease\Variable\array_keys_exists;
use function PhPease\Variable\var_to_float;

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

    public function testVarToFloat()
    {
        // Basic integer string conversions
        $this->assertEquals(12.00, var_to_float('12'));
        $this->assertEquals(123.00, var_to_float('123'));
        $this->assertEquals(1234.00, var_to_float('1234'));
        $this->assertEquals(1234.5, var_to_float('1234.5'));
        $this->assertEquals(12345.00, var_to_float('12345'));

        // Formatting tests
        $this->assertEquals('99.00', number_format(var_to_float('99'), 2, '.', ''));
        $this->assertEquals('99.80', number_format(var_to_float('99.8'), 2, '.', ''));

        // Numeric type conversions
        $this->assertEquals(123.00, var_to_float(123));
        $this->assertEquals(1234.00, var_to_float(1234));
        $this->assertEquals(12345.5, var_to_float(12345.50));
        
        // Test comma as decimal separator
        $this->assertEquals(1.50, var_to_float('1,5'));
        $this->assertEquals(1234.56, var_to_float('1234,56'));
        
        // Test non-numeric characters removal
        $this->assertEquals(12.00, var_to_float('12€'));
        $this->assertEquals(12.00, var_to_float('$12'));
        $this->assertEquals(12.00, var_to_float('$ 12'));
        $this->assertEquals(99.99, var_to_float('$99.99'));
        $this->assertEquals(99.99, var_to_float('$ 99.99'));
        $this->assertEquals(99.99, var_to_float('99.99€'));
        $this->assertEquals(1234.56, var_to_float('1,234.56$'));
        
        // Test different decimal precision
        $this->assertEquals(12.346, var_to_float('12.3456', 3));
        $this->assertEquals(12.3, var_to_float('12.3456', 1));
        $this->assertEquals(12, var_to_float('12.3456', 0));
        
        // Test edge cases
        $this->assertEquals(0.00, var_to_float(''));
        $this->assertEquals(0.00, var_to_float('abc'));
        $this->assertEquals(0.00, var_to_float(null));
        
        // Test large numbers
        $this->assertEquals(1000000.00, var_to_float('1000000'));
        $this->assertEquals(1000000.00, var_to_float('1,000,000'));
    }

    public function testGetArraySize()
    {
        $a1 = [
            'k1' => '123'
        ];

        $this->assertEquals(25, \PhPease\Variable\get_array_size($a1));

        $a2 = [
            'k1' => '123',
            'k2' => 1234567890,
        ];

        $this->assertEquals(47, \PhPease\Variable\get_array_size($a2));
    }
}
