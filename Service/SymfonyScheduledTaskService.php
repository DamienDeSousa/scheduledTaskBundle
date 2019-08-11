<?php

namespace Dades\ScheduledTaskBundle\Service;

use Cron\CronExpression;
use Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTask;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Application;

class SymfonyScheduledTaskService
{
    protected $entityManager;

    protected $repository;

    /**
     * Entity Manager
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SymfonyScheduledTask::class);
    }

    /**
     * Create a new ScheduledTask
     *
     * @return SymfonyScheduledTask
     */
    public function create(): SymfonyScheduledTask
    {
        return new SymfonyScheduledTask();
    }

    /**
     * Return all the scheduled tasks
     *
     * @return SymfonyScheduledTask[]
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
     * @return SymfonyScheduledTask
     *
     * @throws NoSuchEntityException
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
     * @param  SymfonyScheduledTask $scheduledTask
     */
    public function save(SymfonyScheduledTask $scheduledTask)
    {
        $this->entityManager->persist($scheduledTask);
        $this->entityManager->flush();
    }

    /**
     * Update a scheduled task
     *
     * @param  SymfonyScheduledTask $scheduledTask
     */
    public function update(SymfonyScheduledTask $scheduledTask)
    {
        $this->entityManager->flush();
    }

    /**
     * Delete a scheduled task
     *
     * @param  SymfonyScheduledTask $scheduledTask
     */
    public function delete(SymfonyScheduledTask $scheduledTask)
    {
        $this->entityManager->remove($scheduledTask);
        $this->entityManager->flush();
    }

    /**
     * Test if a command should be run now
     *
     * @param  SymfonyScheduledTask $scheduledTask
     *
     * @return bool
     */
    public function isDue(SymfonyScheduledTask $scheduledTask): bool
    {
        $cron = CronExpression::factory($scheduledTask->getCronExpression());

        return $cron->isDue();
    }

    /**
     * Undocumented function
     *
     * @param SymfonyScheduledTask $symfonyScheduledTask
     */
    public function run($symfonyScheduledTask)
    {
        $application = new Application('ScheduledTaskBundle');
        $command = $application->find($symfonyScheduledTask->getName());
        $parameters = [
            'command' => $symfonyScheduledTask->getName(),
        ];
        foreach ($symfonyScheduledTask->getArguments() as $argument) {
            $parameters[$argument->getName()] = $argument->value();
        }
        $arrInput = new ArrayInput($parameters);
        $code = $command->run($arrInput, $output);
    }
}
