<?php

namespace Dades\ScheduledTaskBundle\Service;

use Symfony\Component\Process\Process;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
use Dades\ScheduledTaskBundle\Entity\ScheduledConsoleCommandEntity;

class ScheduledConsoleCommandService extends ScheduledCommandService
{
    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param string                 $scheduledEntityClass
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $scheduledEntityClass
    ) {
        parent::__construct($entityManager, $scheduledEntityClass);
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        return new ScheduledConsoleCommandEntity();
    }

    /**
     * @inheritDoc
     */
    protected function run(ScheduledCommandEntity $scheduledCommandEntity, OutputInterface $output)
    {
        $process = new Process($scheduledCommandEntity->getCommandName());
        $process->setWorkingDirectory($scheduledCommandEntity->getWorkingDirectory());
        $process->run();

        if (!$process->isSuccessful()) {
            /** throw Exception */
        }
    }
}
