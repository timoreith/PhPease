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

class Version
{
    /**
     * @var string
     */
    private $_version;

    /**
     * @param $version
     */
    public function __construct(string $version)
    {
        $this->_version = $version;
    }

    /**
     * @param string $version
     * @return bool
     */
    public function isGreaterThan(string $version): bool
    {
        return version_compare($this->_version, $version) === 1;
    }

    /**
     * @param string $version
     * @return bool
     */
    public function isGreaterThanOrEquals(string $version): bool
    {
        return $this->isGreaterThan($version) or $this->equals($version);
    }

    /**
     * @param string $version
     * @return bool
     */
    public function isLessThan(string $version): bool
    {
        return version_compare($this->_version, $version) === -1;
    }

    /**
     * @param string $version
     * @return bool
     */
    public function isLessOrEqualThan(string $version): bool
    {
        return $this->isLessThan($version) or $this->equals($version);
    }

    /**
     * @param string $version
     * @return bool
     */
    public function equals(string $version): bool
    {
        return version_compare($this->_version, $version) === 0;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->_version;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (!empty($this->_version)) {
            return true;
        }
        return false;
    }
}
