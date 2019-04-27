<?php

namespace Dades\ScheduledTaskBundle\Service\Utility;

use Dades\ScheduledTaskBundle\Service\Utility\OperatingSystem;
use Dades\ScheduledTaskBundle\Exception\OSNotFoundException;

/**
 * Determine if the folder separator is / or \
 *
 * @author Damien DE SOUSA
 */
class FolderSeparator
{
    /**
     * Windows separator
     * @var string
     */
    const WIN_SEPARATOR = "\\";

    /**
     * Linux separator
     * @var string
     */
    const LINUX_SEPARATOR = "/";

    /**
     * Return the right separator
     * @return string [description]
     */
    public static function getSeparator(): string
    {
        $os = OperatingSystem::checkOS();

        switch ($os) {
            case OperatingSystem::WINDOWS:
                return self::WIN_SEPARATOR;
                break;

            case OperatingSystem::LINUX:
                return self::LINUX_SEPARATOR;
                break;

            case OperatingSystem::APPLE:
                return self::LINUX_SEPARATOR;
                break;

            default:
                throw new OSNotFoundException("The [$os] OS is unknown.", 1, __FILE__, __LINE__);
                break;
        }
    }
}
