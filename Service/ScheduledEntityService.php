<?php
/**
 * Service to use to manage the scheduled tasks.
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */
namespace Dades\ScheduledTaskBundle\Service;

use Cron\CronExpression;
use Dades\ScheduledTaskBundle\Entity\ScheduledEntity;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ScheduledEntityService class.
 */
abstract class ScheduledEntityService
{
    /**
     * EntityManager.
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * ScheduledEntity repository.
     *
     * @var ObjectRepository
     */
    protected $repository;

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
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository($scheduledEntityClass);
    }

    /**
     * Create a new ScheduledEntity.
     *
     * @return mixed
     */
    abstract public function create();

    /**
     * Return all the scheduled entities.
     *
     * @return object[]
     */
    public function getScheduledEntities()
    {
        return $this->repository->findAll();
    }

    /**
     * Return the specific scheduled entity.
     *
     * @param  int $id
     *
     * @return mixed
     *
     * @throws NoSuchEntityException
     */
    public function getScheduledEntity(int $id)
    {
        $scheduledTask = $this->repository->find($id);

        if (!$scheduledTask) {
            throw new NoSuchEntityException("No scheduled task found for id [$id]", 1);
        }

        return $scheduledTask;
    }

    /**
     * Save a scheduled entity.
     *
     * @param  ScheduledEntity $scheduledEntity
     */
    public function save(ScheduledEntity $scheduledEntity)
    {
        $this->entityManager->persist($scheduledEntity);
        $this->entityManager->flush();
    }

    /**
     * Update a scheduled entity.
     *
     * @param ScheduledEntity $scheduledEntity
     */
    public function update(ScheduledEntity $scheduledEntity)
    {
        $this->entityManager->flush();
    }

    /**
     * Delete a scheduled entity.
     *
     * @param ScheduledEntity $scheduledEntity
     */
    public function delete(ScheduledEntity $scheduledEntity)
    {
        $this->entityManager->remove($scheduledEntity);
        $this->entityManager->flush();
    }

    /**
     * Test if a command should be run now.
     *
     * @param ScheduledEntity $scheduledEntity
     *
     * @return bool
     */
    public function isDue(ScheduledEntity $scheduledEntity): bool
    {
        $cron = CronExpression::factory($scheduledEntity->getCronExpression());

        return $cron->isDue();
    }
}
