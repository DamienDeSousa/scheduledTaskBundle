<?php

/**
 * Run all defined cron in Symfony.
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Command;

use Dades\ScheduledTaskBundle\Service\Generic\RunnableInterface;
use Dades\ScheduledTaskBundle\Service\ScheduledTaskService;
use Dades\ScheduledTaskBundle\Service\SymfonyScheduledTaskService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    protected $projectDirectory;

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
     * SymfonyScheduledTaskService that manage ScheduledTask
     *
     * @var SymfonyScheduledTaskService
     */
    protected $symfonyScheduledTaskService;

    /**
     * Constructor
     *
     * @param string                      $projectDirectory
     * @param string                      $fileLog
     * @param ScheduledTaskService        $scheduledTaskService
     * @param SymfonyScheduledTaskService $symfonyScheduledTaskService
     */
    public function __construct(
        string $projectDirectory,
        string $fileLog,
        ScheduledTaskService $scheduledTaskService,
        SymfonyScheduledTaskService $symfonyScheduledTaskService
    ) {
        parent::__construct();

        $this->projectDirectory = $projectDirectory;
        $this->fileLog = $fileLog;
        $this->scheduledTaskService = $scheduledTaskService;
        $this->symfonyScheduledTaskService = $symfonyScheduledTaskService;
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setDescription('Run all crons.')
            ->setHelp('Run all crons created in Symfony.');
    }

    /**
     * The body of the command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RunnableInterface[] $taskServices */
        $taskServices = [
            $this->scheduledTaskService,
            $this->symfonyScheduledTaskService,
        ];
        foreach ($taskServices as $taskService) {
            $taskService->run($output, $this->getApplication());
        }
    }
}
