<?php

namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ScheduledCommandEntity class
 *
 * @ORM\Table(name="scheduled_command_entity")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\ScheduledCommandRepository")
 * @ORM\DiscriminatorEntry(value="scheduled_command_entity")
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
    protected $parameters;

    /**
     * The command name
     *
     * @var string
     *
     * @ORM\Column(type="string", name="command_name")
     */
    protected $commandName;

    /**
     * ScheduledCommandEntity constructor.
     */
    public function __construct()
    {
        $this->parameters = new ArrayCollection();
    }

    /**
     * Get the arguments of the Symfony scheduled task
     *
     * @return ArrayCollection
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Add an argument to the Symfony scheduled task
     *
     * @param ScheduledTaskParameter $argument
     */
    public function addParameter(ScheduledTaskParameter $argument)
    {
        $argument->setSymfonyScheduledTask($this);
        $this->parameters[] = $argument;
    }

    /**
     * Remove an argument to the Symfony scheduled task
     *
     * @param ScheduledTaskParameter $argument
     */
    public function removeParameter(ScheduledTaskParameter $argument)
    {
        $argument->setSymfonyScheduledTask(null);
        $this->parameters->removeElement($argument);
    }

    /**
     * Get the command name
     *
     * @return  string
     */
    public function getCommandName()
    {
        return $this->commandName;
    }

    /**
     * Set the command name
     *
     * @param  string  $commandName  The command name
     *
     * @return  self
     */
    public function setCommandName(string $commandName)
    {
        $this->commandName = $commandName;

        return $this;
    }
}
