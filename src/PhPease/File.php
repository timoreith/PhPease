<?php declare(strict_types=1);

/*
 * This file is part of the PhPease package.
 *
 * (c) Timo Reith <mail@timoreith.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhPease;

class File extends \SplFileObject
{
    private $mimeType;

    public function getMimetype()
    {
        if ($this->mimeType === null && class_exists('finfo')) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $this->mimeType = $finfo->file($this->getPathname());
        }

        return $this->mimeType;
    }

    /**
     * @return bool
     */
    public function isZipFile(): bool
    {
        if ($this->getMimetype() === 'application/zip' ||
            strtolower($this->getExtension()) === 'zip') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isGzipFile(): bool
    {
        if ($this->getMimetype() === 'application/gzip' ||
            strtolower($this->getExtension()) === 'gz') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isBz2File(): bool
    {
        if ($this->getMimetype() === 'application/x-bzip2' ||
            strtolower($this->getExtension()) === 'bz2') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isCsvFile(): bool
    {
        if ($this->getMimetype() === 'text/csv' ||
            $this->getMimetype() === 'application/vnd.ms-excel' ||
            strtolower($this->getExtension()) === 'csv') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isXmlFile(): bool
    {
        if ($this->getMimetype() === 'text/xml' ||
            $this->getMimetype() === 'application/xml' ||
            strtolower($this->getExtension()) === 'xml') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isTxtFile(): bool
    {
        if ($this->getMimetype() === 'text/plain' ||
            strtolower($this->getExtension()) === 'txt') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return unlink($this->getPathname());
    }

    public function move($to): bool
    {
        return rename($this->getPathname(), $to);
    }
}