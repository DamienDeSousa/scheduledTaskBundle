<?php
/**
 * Service used to manage and execute scheduled command entities.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Service;

use RuntimeException;
use Symfony\Component\Process\Process;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
use Dades\ScheduledTaskBundle\Repository\ScheduledCommandRepository;

/**
 * Class ScheduledConsoleCommandService.
 */
class ScheduledConsoleCommandService extends ScheduledCommandService
{
    /**
     * Constructor.
     *
     * @param EntityManagerInterface     $entityManager
     * @param ScheduledCommandRepository $scheduledCommandRepository
     * @param string                     $scheduledCommandType
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ScheduledCommandRepository $scheduledCommandRepository,
        string $scheduledCommandType
    ) {
        parent::__construct($entityManager, $scheduledCommandType, $scheduledCommandRepository);
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        return new ScheduledCommandEntity($this->scheduledCommandType);
    }

    /**
     * @inheritDoc
     *
     * @throws RuntimeException
     */
    protected function run(ScheduledCommandEntity $scheduledCommandEntity, OutputInterface $output)
    {
        if ($this->isDue($scheduledCommandEntity)) {
            $fullCommand = $scheduledCommandEntity->getCommandName();

            if ($scheduledCommandEntity->getParameters() !== null) {
                $fullCommand .= ' ' . $scheduledCommandEntity->getParameters();
            }
            $output->writeln($this->getOutputHeader($fullCommand));
            $process = new Process($fullCommand);

            if ($scheduledCommandEntity->getWorkingDirectory() !== null) {
                $process->setWorkingDirectory($scheduledCommandEntity->getWorkingDirectory());
            }
            $process->run();
    
            if (!$process->isSuccessful()) {
                throw new RuntimeException($process->getErrorOutput(), 1);
            }
            $executionMessage = $process->getOutput();
            $output->writeln($executionMessage);
        }
    }
}
