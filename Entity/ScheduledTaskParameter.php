<?php
/**
 * Arguments used for scheduled tasks.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScheduledTaskParameter class.
 *
 * @ORM\Table(name="symfony_scheduled_task_argument")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\ScheduledTaskParameterRepository")
 */
class ScheduledTaskParameter
{
    /**
     * id of the ScheduledTaskParameter entity.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Name of the argument.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * Value of the argument.
     *
     * @var string
     *
     * @ORM\Column(name="value", type="string")
     */
    protected $value;

    /**
     * The Symfony scheduled task of which the argument is applied for.
     *
     * @var ScheduledCommandEntity
     *
     * @ORM\ManyToOne(
     *     targetEntity="Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity",
     *     inversedBy="parameters")
     * @ORM\JoinColumn(name="symfony_scheduled_task_id", referencedColumnName="id")
     */
    protected $symfonyScheduledCommand;

    /**
     * Get the ID of the Symfony scheduled task argument.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of the Symfony scheduled task argument.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the Symfony scheduled task argument.
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of the Symfony scheduled task argument.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of the Symfony scheduled task argument.
     *
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * Get the Symfony scheduled task linked to this argument.
     *
     * @return ScheduledCommandEntity
     */
    public function getSymfonyScheduledCommand()
    {
        return $this->symfonyScheduledCommand;
    }

    /**
     * Set the Symfony scheduled task linked to this argument.
     *
     * @param ScheduledCommandEntity|null $symfonyScheduledCommand
     */
    public function setSymfonyScheduledCommand($symfonyScheduledCommand)
    {
        $this->symfonyScheduledCommand = $symfonyScheduledCommand;
    }
}
