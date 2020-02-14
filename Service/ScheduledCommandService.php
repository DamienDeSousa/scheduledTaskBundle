<?php
/**
 * Service used to manage scheduled command entities.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Service;

use Dades\ScheduledTaskBundle\Repository\ScheduledCommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
use RuntimeException;

/**
 * Class ScheduledCommandService.
 */
abstract class ScheduledCommandService extends ScheduledEntityService
{
    /**
     * The scheduled command type.
     *
     * @var string
     */
    protected $scheduledCommandType;

    /**
     * The scheduled command repository.
     *
     * @var ScheduledCommandRepository
     */
    protected $scheduledCommandRepository;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface     $entityManager
     * @param string                     $scheduledCommandType
     * @param ScheduledCommandRepository $scheduledCommandRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $scheduledCommandType,
        ScheduledCommandRepository $scheduledCommandRepository
    ) {
        parent::__construct($entityManager);

        $this->scheduledCommandType = $scheduledCommandType;
        $this->scheduledCommandRepository = $scheduledCommandRepository;
    }

    /**
     * Runs anything runnable like Symfony commands, Unix/Windows commands.
     *
     * @param ScheduledCommandEntity $scheduledCommandEntity
     * @param OutputInterface        $output
     */
    abstract protected function run(ScheduledCommandEntity $scheduledCommandEntity, OutputInterface $output);

    /**
     * Run all scheduled command entities.
     *
     * @param OutputInterface $output
     */
    public function runAllScheduledCommand(OutputInterface $output)
    {
        $criteria = [
            'scheduledCommandEntityType' => $this->scheduledCommandType
        ];
        /** @var ScheduledCommandEntity[] $scheduledCommandEntities */
        $scheduledCommandEntities = $this->scheduledCommandRepository->findBy($criteria);
        foreach ($scheduledCommandEntities as $scheduledCommandEntity) {
            try {
                $this->run($scheduledCommandEntity, $output);
            } catch (RuntimeException $e) {
                $output->writeln($e->getMessage() . PHP_EOL . $e->getTraceAsString());
            }
        }
    }

    /**
     * Format the header message for log.
     *
     * @param string $command
     *
     * @return string
     */
    protected function getOutputHeader(string $command)
    {
        $currentDate = date('y-m-d H:i:s');

        return '[' . $currentDate . '] ' . $command . ' : ' . PHP_EOL;
    }
}
