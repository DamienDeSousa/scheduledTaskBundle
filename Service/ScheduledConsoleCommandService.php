<?php

namespace Dades\ScheduledTaskBundle\Service;

use RuntimeException;
use Symfony\Component\Process\Process;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
use Dades\ScheduledTaskBundle\Entity\ScheduledConsoleCommandEntity;

class ScheduledConsoleCommandService extends ScheduledCommandService
{
    /**
     * Custom Dades logger.
     *
     * @var Logger
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param string                 $scheduledEntityClass
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $scheduledEntityClass,
        Logger $logger
    ) {
        parent::__construct($entityManager, $scheduledEntityClass);

        $this->logger = $logger;
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
        $fullCommand = $scheduledCommandEntity->getCommandName();
        if ($scheduledCommandEntity->getParameters() !== null) {
            $fullCommand .= ' ' . $scheduledCommandEntity->getParameters();
        }
        $process = new Process($fullCommand);
        $process->setWorkingDirectory($scheduledCommandEntity->getWorkingDirectory());
        $process->run();

        if (!$process->isSuccessful()) {
            throw new RuntimeException($process->getErrorOutput(), 1);
        }

        $executionMessage = $process->getOutput();
        $output->writeln($executionMessage);
    }
}
