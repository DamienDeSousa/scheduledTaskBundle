<?php

namespace Dades\ScheduledTaskBundle\Service\Utility;

/**
 * Determine the OS on which the application is running
 *
 * @author Damien DE SOUSA
 */
class OperatingSystem
{
    const WINDOWS_OS = [
        "CYGWIN_NT-5.1",
        "WIN32",
        "WINNT",
        "Windows"
    ];

    const LINUX_OS = [
        "FreeBSD",
        "HP-UX",
        "IRIX64",
        "Linux",
        "NetBSD",
        "OpenBSD",
        "SunOS",
        "Unix"
    ];

    const APPLE_OS = [
        "Darwin"
    ];

    const WINDOWS = "windows";

    const LINUX = "linux";

    const APPLE = "apple";

    /**
     * Return the OS on which the application is running
     * @return string [description]
     */
    public static function checkOS(): string
    {
        if (\in_array(PHP_OS, self::WINDOWS_OS)) {
            return self::WINDOWS;
        }

        if (\in_array(PHP_OS, self::LINUX_OS)) {
            return self::LINUX;
        }

        if (\in_array(PHP_OS, self::APPLE_OS)) {
            return self::APPLE;
        }
        
        throw new OSNotFoundException("The [$os] OS is unknown.", 1, __FILE__, __LINE__);
    }
}
