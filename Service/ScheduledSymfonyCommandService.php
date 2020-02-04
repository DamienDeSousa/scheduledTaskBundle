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
use Dades\ScheduledTaskBundle\Entity\ScheduledSymfonyCommand;
use Symfony\Component\Process\Process;

/**
 * Class SymfonyScheduledTaskService
 */
class ScheduledSymfonyCommandService extends ScheduledCommandService
{
    /**
     * The project directory
     *
     * @var string
     */
    protected $projectDirectory;

    /**
     * Entity Manager
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $scheduledEntityClass,
        string $projectDirectory
    ) {
        parent::__construct($entityManager, $scheduledEntityClass);

        $this->projectDirectory = $projectDirectory;
    }

    /** Implement abstract methods */

    /**
     * @inheritDoc
     */
    public function create()
    {
        return new ScheduledSymfonyCommand();
    }

    /**
     * @inheritDoc
     */
    protected function run(ScheduledCommandEntity $scheduledCommandEntity, OutputInterface $output)
    {
        $process = new Process($scheduledCommandEntity->getCommandName());
        $process->setWorkingDirectory($this->projectDirectory);
        $code = $process->run();

        if (!$process->isSuccessful()) {
            /** throw Exception */
        }
    }
}
