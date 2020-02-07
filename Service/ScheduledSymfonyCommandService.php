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
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param string                 $scheduledEntityClass
     * @param string                 $projectDirectory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $scheduledEntityClass,
        string $projectDirectory
    ) {
        parent::__construct($entityManager, $scheduledEntityClass);

        $this->workingDirectory = $projectDirectory;
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
     */
    protected function run(ScheduledCommandEntity $scheduledCommandEntity, OutputInterface $output)
    {
        $process = new Process($scheduledCommandEntity->getCommandName());
        $process->setWorkingDirectory($this->workingDirectory);
        $process->run();

        if (!$process->isSuccessful()) {
            /** throw Exception */
        }
    }
}
