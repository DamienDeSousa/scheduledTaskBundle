<?php

namespace Dades\ScheduledTaskBundle\Service;

use Cron\CronExpression;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTask;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Dades\ScheduledTaskBundle\Service\Generic\RunnableInterface;

class SymfonyScheduledTaskService implements RunnableInterface
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
    public function runOne($symfonyScheduledTask, $application, $output)
    {
        $command = $application->find($symfonyScheduledTask->getName());
        $parameters = [
            'command' => $symfonyScheduledTask->getName(),
        ];
        foreach ($symfonyScheduledTask->getArguments() as $argument) {
            $parameters[$argument->getName()] = $argument->getValue();
        }
        $arrInput = new ArrayInput($parameters);
        $code = $command->run($arrInput, $output);
        if ($code != 0) {
            //error
        }
    }

    /**
     * @inheritDoc
     *
     * @throws \InvalidArgumentException
     */
    public function run($output, $application = null)
    {
        if ($application == null) {
            throw new \InvalidArgumentException('$application must be set, null given.', 1);
        }
        $tasks = $this->getScheduledTasks();
        foreach ($tasks as $task) {
            $this->runOne($task, $application, $output);
        }
    }
}
