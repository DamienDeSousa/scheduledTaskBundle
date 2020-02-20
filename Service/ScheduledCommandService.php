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

    /**
     * Find scheduled command entities with specific parameters and corresponding to the right scheduled command type.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
    {
        $criteria['scheduledCommandType'] = $this->scheduledCommandType;

        return $this->scheduledCommandRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Find one scheduled command entity with specific parameters and corresponding to the right scheduled command type.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return object|null
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $criteria['scheduledCommandType'] = $this->scheduledCommandType;

        return $this->scheduledCommandRepository->findOneBy($criteria, $orderBy);
    }

    /**
     * Find all scheduled commands corresponding to the right scheduled command type.
     *
     * @return array
     */
    public function findAll()
    {
        $criteria['scheduledCommandType'] = $this->scheduledCommandType;

        return $this->scheduledCommandRepository->findBy($criteria);
    }

    /**
     * Find a scheduled by its ID and corresponding to the right scheduled command type.
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     *
     * @return ScheduledCommandEntity|null
     */
    public function find($id, int $lockMode = null, int $lockVersion = null)
    {
        /** @var null|ScheduledCommandEntity $scheduledCommandEntity */
        $scheduledCommandEntity = $this->scheduledCommandRepository->find($id, $lockMode, $lockVersion);

        if ($scheduledCommandEntity !== null) {
            if ($scheduledCommandEntity->getScheduledCommandEntityType() !== $this->scheduledCommandType) {
                $scheduledCommandEntity = null;
            }
        }

        return $scheduledCommandEntity;
    }
}
