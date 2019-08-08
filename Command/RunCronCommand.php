<?php

/**
 * Run all defined cron in Symfony.
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Service\ScheduledTaskService;
use Dades\ScheduledTaskBundle\Service\Logger;
use Symfony\Component\Process\Process;
use Dades\ScheduledTaskBundle\Entity\ScheduledTask;

/**
 * RunCronCommand class
 */
class RunCronCommand extends Command
{
    /**
     * Command that run all cron defined in this bundle
     *
     * @var string
     */
    protected static $defaultName = 'cron:run';

    /**
     * The project root directory
     *
     * @var string
     */
    protected $projectDir;

    /**
     * The file that contains tasks logs
     *
     * @var string
     */
    protected $fileLog;

    /**
     * ScheduledTaskService that manage ScheduledTask
     *
     * @var ScheduledTaskService
     */
    protected $scheduledTaskService;

    /**
     * Constructor
     *
     * @param string               $projectdir
     * @param string               $fileLog
     * @param ScheduledTaskService $scheduledTaskService
     */
    public function __construct(string $projectdir, string $fileLog, ScheduledTaskService $scheduledTaskService)
    {
        parent::__construct();

        $this->projectDir = $projectdir;
        $this->fileLog = $fileLog;
        $this->scheduledTaskService = $scheduledTaskService;
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setDescription("Run all crons.")
            ->setHelp("Run all crons created in Symfony.");
    }

    /**
     * The body of the command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->scheduledTaskService->getScheduledTasks() as $task) {
            if ($this->scheduledTaskService->isDue($task)) {
                $this->runProcess($task);
            }
        }
    }

    /**
     * Run the command task
     *
     * @param ScheduledTask $scheduledTask
     */
    protected function runProcess(ScheduledTask $scheduledTask)
    {
        try {
            $process = new Process($scheduledTask->getCommand());
            $exitCode = $process->run();
            $outputMsg = $process->getOutput() . PHP_EOL;

            if (!$process->isSuccessful()) {
                $outputMsg .= $process->getErrorOutput();
            }
        } catch (\Exception $e) {
            $outputMsg = $e->getTraceAsString();
        }

        $logger = new Logger($this->projectDir, $this->fileLog);
        $logger->writeLog($exitCode, $outputMsg);
    }
}
