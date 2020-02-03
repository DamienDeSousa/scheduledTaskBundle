<?php

namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ScheduledCommandEntity class
 *
 * @ORM\Table(name="scheduled_command_entity")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\ScheduledCommandRepository")
 */
abstract class ScheduledCommandEntity extends ScheduledEntity
{
    /**
     * The arguments used for this task
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *  targetEntity="Dades\ScheduledTaskBundle\Entity\ScheduledTaskParameter",
     *  mappedBy="symfonyScheduledTask",
     *  cascade={"persist", "remove"})
     */
    protected $arguments;

    /**
     * ScheduledCommandEntity constructor.
     */
    public function __construct()
    {
        $this->arguments = new ArrayCollection();
    }

    /**
     * Get the arguments of the Symfony scheduled task
     *
     * @return ArrayCollection
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Add an argument to the Symfony scheduled task
     *
     * @param ScheduledTaskParameter $argument
     */
    public function addArgument(ScheduledTaskParameter $argument)
    {
        $argument->setSymfonyScheduledTask($this);
        $this->arguments[] = $argument;
    }

    /**
     * Remove an argument to the Symfony scheduled task
     *
     * @param ScheduledTaskParameter $argument
     */
    public function removeArgument(ScheduledTaskParameter $argument)
    {
        $argument->setSymfonyScheduledTask(null);
        $this->arguments->removeElement($argument);
    }
}
