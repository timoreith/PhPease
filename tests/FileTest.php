<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{
    public function testTxtFile()
    {
        $filepath = __DIR__ . '/data/text.txt';

        $file = new \PhPease\File($filepath);

        $this->assertFalse($file->isCsvFile(), 'is csv file');
        $this->assertFalse($file->isXmlFile(), 'is xml file');
        $this->assertTrue($file->isTxtFile(), 'is txt file');
        $this->assertFalse($file->isZipFile(), 'is zip file');
        $this->assertFalse($file->isGzipFile(), 'is gzip file');
    }

    public function testCsvFile()
    {
        $filepath = __DIR__ . '/data/test.csv';

        $file = new \PhPease\File($filepath);

        $this->assertTrue($file->isCsvFile(), 'is csv file');
        $this->assertFalse($file->isXmlFile(), 'is xml file');
        $this->assertTrue($file->isTxtFile(), 'is txt file');
        $this->assertFalse($file->isZipFile(), 'is zip file');
        $this->assertFalse($file->isGzipFile(), 'is gzip file');
    }

    public function testXmlFile()
    {
        $filepath = __DIR__ . '/data/test.xml';

        $file = new \PhPease\File($filepath);

        $this->assertTrue($file->isXmlFile(), 'is xml file');
        $this->assertFalse($file->isCsvFile(), 'is csv file');
        $this->assertFalse($file->isTxtFile(), 'is txt file');
        $this->assertFalse($file->isZipFile(), 'is zip file');
        $this->assertFalse($file->isGzipFile(), 'is gzip file');
    }

    public function testZipFile()
    {
        $filepath = __DIR__ . '/data/text.txt.zip';

        $file = new \PhPease\File($filepath);

        $this->assertFalse($file->isXmlFile(), 'is xml file');
        $this->assertFalse($file->isCsvFile(), 'is csv file');
        $this->assertFalse($file->isTxtFile(), 'is txt file');
        $this->assertTrue($file->isZipFile(), 'is zip file');
        $this->assertFalse($file->isGzipFile(), 'is gzip file');
    }

    public function testGzFile()
    {
        $filepath = __DIR__ . '/data/text.txt.gz';

        $file = new \PhPease\File($filepath);

        $this->assertFalse($file->isXmlFile(), 'is xml file');
        $this->assertFalse($file->isCsvFile(), 'is csv file');
        $this->assertFalse($file->isTxtFile(), 'is txt file');
        $this->assertFalse($file->isZipFile(), 'is zip file');
        $this->assertTrue($file->isGzipFile(), 'is gzip file');
    }
}
