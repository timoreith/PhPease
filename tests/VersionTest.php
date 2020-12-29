<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class VersionTest extends TestCase
{
    private $version;

    protected function setUp(): void
    {
        $this->version = new PhPease\Version('1.2.3');
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->version->isGreaterThan('1.0'));
        $this->assertTrue($this->version->isGreaterThan('1.2.0'));
        $this->assertTrue($this->version->isGreaterThan('1.2.2'));

        $this->assertFalse($this->version->isGreaterThan('1.2.3'));

        $this->assertFalse($this->version->isGreaterThan('1.2.4'));
        $this->assertFalse($this->version->isGreaterThan('1.3.2'));
        $this->assertFalse($this->version->isGreaterThan('2.0'));
    }

    public function testIsGreaterThanOrEquals()
    {
        $this->assertTrue($this->version->isGreaterOrEqualThan('1.0'));
        $this->assertTrue($this->version->isGreaterOrEqualThan('1.2.3'));
        $this->assertFalse($this->version->isGreaterOrEqualThan('1.2.4'));
    }

    public function testIsLessThan()
    {
        $this->assertTrue($this->version->isLessThan('2.0'));
        $this->assertTrue($this->version->isLessThan('1.3.0'));
        $this->assertTrue($this->version->isLessThan('1.2.4'));

        $this->assertFalse($this->version->isLessThan('1.2.3'));

        $this->assertFalse($this->version->isLessThan('1.2.2'));
        $this->assertFalse($this->version->isLessThan('1.1.0'));
        $this->assertFalse($this->version->isLessThan('1.0'));
    }

    public function testIsLessThanOrEquals()
    {
        $this->assertTrue($this->version->isLessOrEqualThan('2.0'));
        $this->assertTrue($this->version->isLessOrEqualThan('1.2.3'));
        $this->assertFalse($this->version->isLessOrEqualThan('1.2.2'));
    }

    public function testEquals()
    {
        $this->assertTrue($this->version->equals('1.2.3'));
        $this->assertFalse($this->version->equals('1.2.4'));
    }

    public function testGetVersion()
    {
        $this->assertEquals('1.2.3', $this->version->getVersion());
    }

    public function testIsValid()
    {
        $this->assertTrue($this->version->isValid());
    }
}
