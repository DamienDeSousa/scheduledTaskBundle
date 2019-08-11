<?php

namespace Dades\ScheduledTaskBundle\Service\Generic;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;

interface RunnableInterface
{
    /**
     * Runs anything runnable like Symfony commands, Unix/Windows commands...
     *
     * @param OutputInterface   $output
     * @param Application|null  $application
     */
    public function run($output, $application = null);
}
