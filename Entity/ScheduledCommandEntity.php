<?php
/**
 * Defines the required attributes for a scheduled command entity.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Levelab\Doctrine\DiscriminatorBundle\Annotation\DiscriminatorEntry;

/**
 * ScheduledCommandEntity class.
 *
 * @ORM\Table(name="scheduled_command_entity")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\ScheduledCommandRepository")
 * @DiscriminatorEntry("scheduled_command_entity")
 */
abstract class ScheduledCommandEntity extends ScheduledEntity
{
    /**
     * The parameters used for this task.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *  targetEntity="Dades\ScheduledTaskBundle\Entity\ScheduledTaskParameter",
     *  mappedBy="symfonyScheduledCommand",
     *  cascade={"persist", "remove"})
     */
    protected $parameters;

    /**
     * The command name.
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
        parent::__construct();

        $this->parameters = new ArrayCollection();
    }

    /**
     * Get the arguments of the scheduled command.
     *
     * @return ArrayCollection
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Add an argument to the scheduled command.
     *
     * @param ScheduledTaskParameter $argument
     *
     * @return bool|true
     */
    public function addParameter(ScheduledTaskParameter $argument)
    {
        $argument->setSymfonyScheduledCommand($this);

        return $this->parameters->add($argument);
    }

    /**
     * Remove an argument to the scheduled command.
     *
     * @param ScheduledTaskParameter $argument
     *
     * @return bool
     */
    public function removeParameter(ScheduledTaskParameter $argument)
    {
        $argument->setSymfonyScheduledCommand(null);

        return $this->parameters->removeElement($argument);
    }

    /**
     * Get the command name.
     *
     * @return string
     */
    public function getCommandName()
    {
        return $this->commandName;
    }

    /**
     * Set the command name.
     *
     * @param string $commandName
     *
     * @return $this
     */
    public function setCommandName(string $commandName)
    {
        $this->commandName = $commandName;

        return $this;
    }
}
