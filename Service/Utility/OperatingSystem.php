<?php
/**
 * Detect the using operating system.
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Service\Utility;

use Dades\ScheduledTaskBundle\Exception\OSNotFoundException;

/**
 * OperatingSystem class
 */
class OperatingSystem
{
    /**
     * Windows OS code
     *
     * @var string
     */
    const WINDOWS = "WIN";

    /**
     * Linux / Unix OS code
     *
     * @var string
     */
    const LINUX = "LINUX";

    /**
     * Apple OS code
     *
     * @var string
     */
    const APPLE = 'APPLE';

    /**
     * List of Windows OS types
     *
     * @var array
     */
    const WINDOWS_OS = [
        'Windows',
        'WIN32',
        'WINNT',
        'CYGWIN_NT-5.1'
    ];

    /**
     * List of Linux OS types
     *
     * @var array
     */
    const LINUX_OS = [
        'FreeBSD',
        'HP-UX',
        'IRIX64',
        'Linux',
        'NetBSD',
        'OpenBSD',
        'SunOS',
        'Unix'
    ];

    /**
     * List of Apple OS types
     *
     * @var array
     */
    const APPLE_OS = [
        'Darwin'
    ];

    /**
     * Return the OS on which the application is running
     *
     * @return string
     *
     * @throws OSNotFoundException
     */
    public static function checkOS(): string
    {
        if (\in_array(self::getOS(), self::WINDOWS_OS)) {
            return self::WINDOWS;
        } elseif (in_array(self::getOS, self::LINUX_OS)) {
            return self::LINUX;
        } elseif (\in_array(self::getOS(), self::APPLE_OS)) {
            return self::APPLE;
        }

        throw new OSNotFoundException('The OS ['.self::getOS().'] is not found', 1, __FILE__, __LINE__);
    }

    /**
     * Get the current OS
     *
     * @return string
     */
    public static function getOS()
    {
        return PHP_OS;
    }
}
