<?php
/**
 * Service to use for manage the scheduled tasks.
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Service;

use Dades\ScheduledTaskBundle\Entity\ScheduledTask;
use Dades\ScheduledTaskBundle\Exception\BadCommandException;
use Doctrine\ORM\EntityManagerInterface;
use Dades\ScheduledTaskBundle\Exception\OSNotFoundException;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Cron\CronExpression;

/**
 * ScheduledTaskService class
 */
class ScheduledTaskService
{
    /**
     * EntityManager
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * ScheduledTask repository
     *
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * Entity Manager
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ScheduledTask::class);
    }

    /**
     * Create a new ScheduledTask
     *
     * @return ScheduledTask
     */
    public function create(): ScheduledTask
    {
        return new ScheduledTask();
    }

    /**
     * Return all the scheduled tasks
     *
     * @return ScheduledTask[]
     */
    public function getScheduledTasks()
    {
        return $this->repository->findAll();
    }

    /**
     * Return the specific scheduled task
     *
     * @param  int    $id
     *
     * @return ScheduledTask|null
     */
    public function getScheduledTask(int $id)
    {
        $scheduledTask = $this->repository->find($id);

        if (!$scheduledTask) {
            throw new NoSuchEntityException("No scheduled task found for id [$id]", 1);
        }

        return $scheduledTask;
    }

    /**
     * Save a scheduled task
     *
     * @param  ScheduledTask $scheduledTask
     */
    public function save(ScheduledTask $scheduledTask)
    {
        $this->entityManager->persist($scheduledTask);
        $this->entityManager->flush();
    }

    /**
     * Update a scheduled task
     *
     * @param  ScheduledTask $scheduledTask
     */
    public function update(ScheduledTask $scheduledTask)
    {
        $this->entityManager->flush();
    }

    /**
     * Delete a scheduled task
     *
     * @param  ScheduledTask $scheduledTask
     */
    public function delete(ScheduledTask $scheduledTask)
    {
        $this->entityManager->remove($scheduledTask);
        $this->entityManager->flush();
    }

    /**
     * Test if a command should be run now
     *
     * @param  ScheduledTask $scheduledTask
     *
     * @return bool
     */
    public function isDue(ScheduledTask $scheduledTask): bool
    {
        $cron = CronExpression::factory($scheduledTask->getCronExpresion());

        return $cron->isDue();
    }
}
