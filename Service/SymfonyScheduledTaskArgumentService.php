<?php
/**
 * Service that manages the Symfony scheduled task arguments.
 *
 * @author    Damien DE SOUSA
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Service;

use Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTaskArgument;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SymfonyScheduledTaskArgumentService
 */
class SymfonyScheduledTaskArgumentService
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
        $this->repository = $this->entityManager->getRepository(SymfonyScheduledTaskArgument::class);
    }

    /**
     * Create a new SymfonyScheduledTaskArgument
     *
     * @return SymfonyScheduledTaskArgument
     */
    public function create()
    {
        return new SymfonyScheduledTaskArgument();
    }

    /**
     * Get all SymfonyScheduledTaskArgument
     *
     * @return SymfonyScheduledTaskArgument[]
     */
    public function getSymfonyScheduledTaskArguments()
    {
        return $this->repository->findAll();
    }

    /**
     * Get the arguments for a given Symfony scheduled task
     *
     * @param $id
     *
     * @return SymfonyScheduledTaskArgument
     *
     * @throws NoSuchEntityException
     */
    public function getSymfonyScheduledTaskArgument($id)
    {
        $symfonyScheduledTaskArgument = $this->repository->find($id);

        if (!$symfonyScheduledTaskArgument) {
            throw new NoSuchEntityException("No scheduled task found for id [$id]", 1);
        }

        return $symfonyScheduledTaskArgument;
    }

    /**
     * Save a given Symfony scheduled task argument
     *
     * @param $symfonyScheduledTaskArgument
     */
    public function save($symfonyScheduledTaskArgument)
    {
        $this->entityManager->persist($symfonyScheduledTaskArgument);
        $this->entityManager->flush();
    }

    /**
     * Update a Symfony scheduled task argument
     *
     * @param $symfonyScheduledTaskArgument
     */
    public function update($symfonyScheduledTaskArgument)
    {
        $this->entityManager->flush();
    }

    /**
     * Remove a given Symfony scheduled task argument
     *
     * @param $symfonyScheduledTaskArgument
     */
    public function delete($symfonyScheduledTaskArgument)
    {
        $this->entityManager->remove($symfonyScheduledTaskArgument);
        $this->entityManager->flush();
    }
}
