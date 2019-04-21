<?php

namespace Dades\ScheduledTaskBundle\Service\Utility;

class OperatingSystem
{
    const WINDOWS = "WIN";

    const LINUX = "LINUX";

    public static function checkOS(): string
    {
        if (strpos(PHP_OS, self::WINDOWS) !== false) {
            return self::WINDOWS;
        }

        return self::LINUX;
    }
}
