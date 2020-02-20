<?php
/**
 * Run all defined cron in Symfony.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2019
 */
namespace Dades\ScheduledTaskBundle\Command;

use Dades\ScheduledTaskBundle\Service\ScheduledCommandService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * RunCronCommand class.
 */
class RunCronCommand extends Command
{
    /**
     * Command that run all cron defined in this bundle.
     *
     * @var string
     */
    protected static $defaultName = 'dades:scheduled-command:run';

    /**
     * The project root directory.
     *
     * @var string
     */
    protected $projectDirectory;

    /**
     * The file that contains tasks logs.
     *
     * @var string
     */
    protected $fileLog;

    /**
     * The scheduled command services.
     *
     * @var ScheduledCommandService[]
     */
    protected $scheduledCommandServices;

    /**
     * Constructor.
     *
     * @param string $projectDirectory
     * @param string $fileLog
     * @param array  $scheduledCommandServices
     */
    public function __construct(
        string $projectDirectory,
        string $fileLog,
        array $scheduledCommandServices
    ) {
        $this->projectDirectory = $projectDirectory;
        $this->fileLog = $fileLog;
        $this->scheduledCommandServices = $scheduledCommandServices;

        parent::__construct();
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this->setDescription('Run all crons.')
            ->setHelp('Run all crons created in Symfony.');
    }

    /**
     * The body of the command.
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->scheduledCommandServices as $scheduledCommandService) {
            $scheduledCommandService->runAllScheduledCommand($output);
        }
    }
}
