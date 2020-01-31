<?php
/**
 * Interface that proposes a run method to execute a task, a command for example
 *
 * @author    Damien DE SOUSA
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Service\Generic;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface RunnableInterface
 */
interface RunnableInterface
{
    /**
     * Runs anything runnable like Symfony commands, Unix/Windows commands
     *
     * @param OutputInterface   $output
     * @param Application|null  $application
     */
    public function run($output, $application = null);
}
