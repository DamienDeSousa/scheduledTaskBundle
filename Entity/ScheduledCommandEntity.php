<?php
/**
 * Defines the required attributes for a scheduled command entity.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Levelab\Doctrine\DiscriminatorBundle\Annotation\DiscriminatorEntry;

/**
 * ScheduledCommandEntity class.
 *
 * @ORM\Table(name="scheduled_command_entity")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\ScheduledCommandRepository")
 * @DiscriminatorEntry("scheduled_command_entity")
 */
class ScheduledCommandEntity extends ScheduledEntity
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
     * The parameters of the command. Can be empty.
     *
     * @var string
     *
     * @ORM\Column(type="string", name="parameters", nullable=true)
     */
    protected $parameters;

    /**
     * The type of the scheduled command entity.
     *
     * @var string
     *
     * @ORM\Column(type="string", name="scheduled_command_entity_type")
     */
    protected $scheduledCommandEntityType;

    /**
     * ScheduledCommandEntity constructor.
     *
     * @param string $scheduledCommandEntityType
     */
    public function __construct(string $scheduledCommandEntityType)
    {
        parent::__construct();

        $this->scheduledCommandEntityType = $scheduledCommandEntityType;
    }

    /**
     * @return string
     */
    public function getScheduledCommandEntityType(): string
    {
        return $this->scheduledCommandEntityType;
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
     * @return string|null
     */
    public function getWorkingDirectory()
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

    /**
     * Get the parameters of the command. Can be empty.
     *
     * @return string|null
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set the parameters of the command. Can be empty.
     *
     * @param  string  $parameters  The parameters of the command. Can be empty.
     *
     * @return  self
     */
    public function setParameters(string $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }
}
