<?php
/**
 * Determine if the folder separator is / or \
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */
namespace Dades\ScheduledTaskBundle\Service\Utility;

use Dades\ScheduledTaskBundle\Service\Utility\OperatingSystem;
use Dades\ScheduledTaskBundle\Exception\OSNotFoundException;

/**
 * FolderSeparator class
 */
class FolderSeparator
{
    /**
     * Windows separator
     *
     * @var string
     */
    const WIN_SEPARATOR = '\\';

    /**
     * Linux separator
     *
     * @var string
     */
    const LINUX_SEPARATOR = '/';

    /**
     * Apple separator
     *
     * @var string
     */
    const APPLE_SEPARATOR = '/';

    /**
     * Return the right separator
     *
     * @return string
     *
     * @throws OSNotFoundException
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
                return self::APPLE_SEPARATOR;
                break;

            default:
                throw new OSNotFoundException("The [$os] OS is unknown.", 1, __FILE__, __LINE__);
                break;
        }
    }
}
