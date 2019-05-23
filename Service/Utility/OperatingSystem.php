<?php

namespace Dades\ScheduledTaskBundle\Service\Utility;

/**
 * Determine the OS on which the application is running
 *
 * @author Damien DE SOUSA
 */
class OperatingSystem
{
    /**
     * Windows OS
     * @var string
     */
    const WINDOWS = "WIN";

    /**
     * Linux / Unix OS
     * @var string
     */
    const LINUX = "LINUX";

    /**
     * Return the OS on which the application is running
     * @return string [description]
     */
    public static function checkOS(): string
    {
        if (strpos(PHP_OS, self::WINDOWS) !== false) {
            return self::WINDOWS;
        }

        return self::LINUX;
    }
}
