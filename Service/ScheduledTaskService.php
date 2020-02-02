<?php

/**
 * Service to use for manage the scheduled tasks.
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Service;

use Cron\CronExpression;
use Dades\ScheduledTaskBundle\Entity\ScheduledTask;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Dades\ScheduledTaskBundle\Service\Generic\RunnableInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * ScheduledTaskService class
 */
class ScheduledTaskService implements RunnableInterface
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
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * Entity Manager
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
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
     * @return object[]
     */
    public function getScheduledTasks()
    {
        return $this->repository->findAll();
    }

    /**
     * Return the specific scheduled task
     *
     * @param  int $id
     *
     * @return ScheduledTask|object
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
        $cron = CronExpression::factory($scheduledTask->getCronExpression());

        return $cron->isDue();
    }

    /**
     * Run a scheduled task
     *
     * @param ScheduledTask|object $scheduledTask
     * @param OutputInterface      $output
     */
    public function runOne(ScheduledTask $scheduledTask, $output)
    {
        try {
            $process = new Process([$scheduledTask->getCommand()]);
            $exitCode = $process->run();
            $outputMsg = $process->getOutput() . PHP_EOL;

            if (!$process->isSuccessful()) {
                $outputMsg .= $process->getErrorOutput();
            }
        } catch (\Exception $e) {
            $outputMsg = $e->getTraceAsString();
        }
        $output->writeln('[' . date('Y-m-d H:i:s') . ']: ' . $outputMsg);
    }

    /**
     * Run all scheduled tasks
     *
     * @param OutputInterface  $output
     * @param Application|null $application
     */
    public function run($output, $application = null)
    {
        $tasks = $this->getScheduledTasks();
        foreach ($tasks as $task) {
            $this->runOne($task, $output);
        }
    }
}
