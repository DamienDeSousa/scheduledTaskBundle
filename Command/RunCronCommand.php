<?php

namespace Dades\ScheduledTaskBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Service\ScheduledTaskService;
use Dades\ScheduledTaskBundle\Service\Logger;

/**
 * Run all defined cron in Symfony.
 *
 * @author Damien DE SOUSA
 */
class RunCronCommand extends Command
{
    /**
     * Command that run all cron defined in this bundle
     * @var string
     */
    protected static $defaultName = 'cron:run';

    /**
     * The project root directory
     * @var string
     */
    protected $projectDir;

    /**
     * The file that contains tasks logs
     * @var string
     */
    protected $fileLog;

    /**
     * ScheduledTaskService that manage ScheduledTask
     * @var ScheduledTaskService
     */
    protected $scheduledTaskService;

    /**
     * @param string               $projectdir           [description]
     * @param string               $fileLog              [description]
     * @param ScheduledTaskService $scheduledTaskService [description]
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
     * @return void [description]
     */
    protected function configure()
    {
        $this->setDescription("Run all crons.")
            ->setHelp("Run all crons created in Symfony.");
    }

    /**
     * The body of the command
     * @param  InputInterface  $input  [description]
     * @param  OutputInterface $output [description]
     * @return void                  [description]
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->scheduledTaskService->getScheduledTasks() as $task) {
            $stderr = [];
            $status = 0;

            if ($this->scheduledTaskService->isDue($task)) {
                exec($task->getCommand(), $stderr, $status);

                if ($status !== 0) {
                    array_unshift($stderr, "The command [".$task->getCommand()."] failed.");
                }

                if ($status === 0) {
                    array_unshift($stderr, "The command [".$task->getCommand()."] succeed.");
                }

                $logger = new Logger($this->projectDir, $this->fileLog);
                $logger->writeLog($status, $stderr);
            }
        }
    }
}
