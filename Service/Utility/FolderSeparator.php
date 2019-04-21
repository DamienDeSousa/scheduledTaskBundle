<?php

namespace Dades\ScheduledTaskBundle\Service\Utility;

use Dades\ScheduledTaskBundle\Service\Utility\OperatingSystem;

class FolderSeparator
{
    const WIN_SEPARATOR = "\\";
    const LINUX_SEPARATOR = "/";

    public static function getSeparator(): string
    {
        $os = OperatingSystem::checkOS();

        switch ($os) {
            case 'WIN':
                return self::WIN_SEPARATOR;
                break;

            case 'LINUX':
                return self::LINUX_SEPARATOR;
                break;

            default:
                //throw une erreur
                break;
        }
    }
}
