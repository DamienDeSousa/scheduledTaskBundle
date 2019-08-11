<?php

namespace Dades\ScheduledTaskBundle\Service;

use Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTaskArgument;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;
use Doctrine\ORM\EntityManagerInterface;

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
        $this->repository = $this->entityManager->getRepository(SymfonyScheduledTaskArgument::class);
    }

    /**
     * Undocumented function
     *
     * @return SymfonyScheduledTaskArgument
     */
    public function create()
    {
        return new SymfonyScheduledTaskArgument();
    }

    public function getSymfonyScheduledTaskArguments()
    {
        return $this->repository->findAll();
    }

    public function getSymfonyScheduledTaskArgument($id)
    {
        $symfonyScheduledTaskArgument = $this->repository->find($id);

        if (!$symfonyScheduledTaskArgument) {
            throw new NoSuchEntityException("No scheduled task found for id [$id]", 1);
        }

        return $symfonyScheduledTaskArgument;
    }

    public function save($symfonyScheduledTaskArgument)
    {
        $this->entityManager->persist($symfonyScheduledTaskArgument);
        $this->entityManager->flush();
    }

    public function update($symfonyScheduledTaskArgument)
    {
        $this->entityManager->flush();
    }

    public function delete($symfonyScheduledTaskArgument)
    {
        $this->entityManager->remove($symfonyScheduledTaskArgument);
        $this->entityManager->flush();
    }
}
