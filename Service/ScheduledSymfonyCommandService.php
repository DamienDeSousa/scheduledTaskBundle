<?php
/**
 * Service that manages the Symfony scheduled tasks.
 *
 * @author    Damien DE SOUSA
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
use Dades\ScheduledTaskBundle\Entity\ScheduledSymfonyCommandEntity;
use Exception;
use RuntimeException;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Class SymfonyScheduledTaskService.
 */
class ScheduledSymfonyCommandService extends ScheduledCommandService
{
    /**
     * The working directory.
     *
     * @var string
     */
    protected $workingDirectory;

    /**
     * The php executable path.
     *
     * @var string
     */
    protected $phpBin;

    /**
     * Symfony console executable path.
     *
     * @var string
     */
    protected $consoleBin;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param string                 $scheduledEntityClass
     * @param string                 $projectDirectory
     *
     * @throws Exception
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $scheduledEntityClass,
        string $projectDirectory
    ) {
        parent::__construct($entityManager, $scheduledEntityClass);

        $this->workingDirectory = $projectDirectory;
        $phpFinder = new PhpExecutableFinder();
        $this->phpBin = $phpFinder->find();
        if (!$this->phpBin) {
            throw new Exception('The php executable could not be found, add it to your PATH');
        }
        $this->consoleBin = 'bin' . DIRECTORY_SEPARATOR . 'console';
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        return new ScheduledSymfonyCommandEntity();
    }

    /**
     * @inheritDoc
     *
     * @throws RuntimeException
     */
    protected function run(ScheduledCommandEntity $scheduledCommandEntity, OutputInterface $output)
    {
        if ($this->isDue($scheduledCommandEntity)) {
            $fullCommand = $this->phpBin . ' ' . $this->consoleBin . ' ' . $scheduledCommandEntity->getCommandName();
            if ($scheduledCommandEntity->getParameters() !== null) {
                $fullCommand .= ' ' . $scheduledCommandEntity->getParameters();
            }
            $output->writeln($this->getOutputHeader($fullCommand));
            $process = new Process($fullCommand);
            $process->setWorkingDirectory($this->workingDirectory);
            $process->run();
    
            if (!$process->isSuccessful()) {
                throw new RuntimeException($process->getErrorOutput(), 1);
            }
    
            $executionMessage = $process->getOutput();
            $output->writeln($executionMessage);
        }
    }
}
