<?php
/**
 * Service that manages the Symfony scheduled task arguments.
 *
 * @author    Damien DE SOUSA
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Service;

use Dades\ScheduledTaskBundle\Entity\ScheduledTaskParameter;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ScheduledTaskParameterService
 */
class ScheduledTaskParameterService
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
     * Constructor
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ScheduledTaskParameter::class);
    }

    /**
     * Create a new ScheduledTaskParameter
     *
     * @return ScheduledTaskParameter
     */
    public function create()
    {
        return new ScheduledTaskParameter();
    }

    /**
     * Get all ScheduledTaskParameter
     *
     * @return ScheduledTaskParameter[]
     */
    public function getScheduledTaskParameters()
    {
        return $this->repository->findAll();
    }

    /**
     * Get the arguments for a given Symfony scheduled task
     *
     * @param $id
     *
     * @return SymfonyScheduledTaskArgScheduledTaskParameterument
     *
     * @throws NoSuchEntityException
     */
    public function getScheduledTaskParameter($id)
    {
        $scheduledTaskParameter = $this->repository->find($id);

        if (!$scheduledTaskParameter) {
            throw new NoSuchEntityException("No scheduled task found for id [$id]", 1);
        }

        return $scheduledTaskParameter;
    }

    /**
     * Save a given Symfony scheduled task argument
     *
     * @param $scheduledTaskParameter
     */
    public function save($scheduledTaskParameter)
    {
        $this->entityManager->persist($scheduledTaskParameter);
        $this->entityManager->flush();
    }

    /**
     * Update a Symfony scheduled task argument
     *
     * @param $scheduledTaskParameter
     */
    public function update($ScheduledTaskParameter)
    {
        $this->entityManager->flush();
    }

    /**
     * Remove a given Symfony scheduled task argument
     *
     * @param $scheduledTaskParameter
     */
    public function delete($scheduledTaskParameter)
    {
        $this->entityManager->remove($scheduledTaskParameter);
        $this->entityManager->flush();
    }
}
