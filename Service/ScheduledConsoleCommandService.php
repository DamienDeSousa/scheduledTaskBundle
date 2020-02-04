<?php

namespace Dades\ScheduledTaskBundle\Service;

use Symfony\Component\Process\Process;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
use Dades\ScheduledTaskBundle\Entity\ScheduledConsoleCommand;

class ScheduledConsoleCommandService extends ScheduledCommandService
{
    /**
     * Undocumented function
     *
     * @param EntityManagerInterface $entityManager
     * @param string $scheduledEntityClass
     * @param string $projectDirectory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $scheduledEntityClass,
        string $projectDirectory
    ) {
        parent::__construct($entityManager, $scheduledEntityClass);

        $this->projectDirectory = $projectDirectory;
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        return new ScheduledConsoleCommand();
    }

    /**
     * @inheritDoc
     */
    protected function run(ScheduledCommandEntity $scheduledCommandEntity, OutputInterface $output)
    {
        $process = new Process($scheduledCommandEntity->getCommandName());
        $code = $process->run();

        if (!$process->isSuccessful()) {
            /** throw Exception */
        }
    }
}
