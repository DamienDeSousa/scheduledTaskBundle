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
     * The command name.
     *
     * @var string
     *
     * @ORM\Column(type="string", name="command_name")
     */
    protected $commandName;

    /**
     * The working directory of the command.
     *
     * @var string
     *
     * @ORM\Column(type="string", name="working_directory", nullable=true)
     */
    protected $workingDirectory;

    /**
     * ScheduledCommandEntity constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the command name.
     *
     * @return string
     */
    public function getCommandName(): string
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

    /**
     * Get the working directory of the command.
     *
     * @return string
     */
    public function getWorkingDirectory(): string
    {
        return $this->workingDirectory;
    }

    /**
     * Set the working directory of the command.
     *
     * @param string $workingDirectory
     *
     * @return $this
     */
    public function setWorkingDirectory(string $workingDirectory)
    {
        $this->workingDirectory = $workingDirectory;

        return $this;
    }
}
