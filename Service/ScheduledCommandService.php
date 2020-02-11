<?php
/**
 * Service used to manage scheduled command entities.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Service;

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
        /** @var ScheduledCommandEntity[] $scheduledCommandEntities */
        $scheduledCommandEntities = $this->getScheduledEntities();
        foreach ($scheduledCommandEntities as $scheduledCommandEntity) {
            try {
                $this->run($scheduledCommandEntity, $output);
            } catch (RuntimeException $e) {
                $output->writeln($e->getMessage() . PHP_EOL . $e->getTraceAsString());
            }
        }
    }
}
