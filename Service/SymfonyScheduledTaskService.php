<?php
/**
 * Service that manages the Symfony scheduled tasks.
 *
 * @author    Damien DE SOUSA
 * @copyright 2020
 */

namespace Dades\ScheduledTaskBundle\Service;

use Cron\CronExpression;
use Dades\ScheduledTaskBundle\Repository\SymfonyScheduledTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTask;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Dades\ScheduledTaskBundle\Service\Generic\RunnableInterface;

/**
 * Class SymfonyScheduledTaskService
 */
class SymfonyScheduledTaskService
{
    /**
     * The entity manager
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * The Symfony scheduled task repository
     *
     * @var SymfonyScheduledTaskRepository
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
//        $this->repository = $this->entityManager->getRepository(SymfonyScheduledTask::class);
    }

    /**
     * Create a new ScheduledTask
     *
     */
    public function create()
    {
    }

    /**
     * Return all the scheduled tasks
     *
     */
    public function getScheduledTasks()
    {
    }

    /**
     * Return the specific scheduled task
     *
     * @param  int $id
     *
     *
     * @throws NoSuchEntityException
     */
    public function getScheduledTask(int $id)
    {
        $scheduledTask = $this->repository->find($id);

        if (!$scheduledTask) {
            throw new NoSuchEntityException("No scheduled task found for id [$id]", 1);
        }

    }

    /**
     * Save a scheduled task
     *
     * @param  $scheduledTask
     */
    public function save($scheduledTask)
    {
        $this->entityManager->persist($scheduledTask);
        $this->entityManager->flush();
    }

    /**
     * Update a scheduled task
     *
     * @param  $scheduledTask
     */
    public function update( $scheduledTask)
    {
        $this->entityManager->flush();
    }

    /**
     * Delete a scheduled task
     *
     * @param  $scheduledTask
     */
    public function delete($scheduledTask)
    {
        $this->entityManager->remove($scheduledTask);
        $this->entityManager->flush();
    }

    /**
     * Test if a Symfony command should be run now
     *
     * @param  $scheduledTask
     *
     */
    public function isDue($scheduledTask)
    {
    }

    /**
     * Run a Symfony scheduled command.
     *
     * @param Application          $application
     * @param OutputInterface      $output
     *
     * @throws Exception
     */
    public function runOne($application, $output)
    {
//        $command = $application->find($symfonyScheduledTask->getName());
//        $parameters = [
//            'command' => $symfonyScheduledTask->getName(),
//        ];
//        foreach ($symfonyScheduledTask->getArguments() as $argument) {
//            $parameters[$argument->getName()] = $argument->getValue();
//        }
//        $arrInput = new ArrayInput($parameters);
//        $code = $command->run($arrInput, $output);

        /** @todo manage exception */
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function run($output, $application = null)
    {
//        if ($application == null) {
//            throw new InvalidArgumentException('$application must be set, null given.', 1);
//        }
//        $tasks = $this->getScheduledTasks();
//        foreach ($tasks as $task) {
//            $this->runOne($task, $application, $output);
//        }
    }
}
