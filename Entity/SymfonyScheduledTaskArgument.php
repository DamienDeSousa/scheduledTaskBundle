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
 * SymfonyScheduledTaskArgument class
 *
 * @ORM\Table(name="symfony_scheduled_task_argument")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\SymfonyScheduledTaskArgumentRepository")
 */
class SymfonyScheduledTaskArgument
{
    /**
     * id of the SymfonyScheduledTaskArgument entity
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Name of the argument
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * Value of the argument
     *
     * @var string
     *
     * @ORM\Column(name="value", type="string")
     */
    protected $value;

    /**
     * The Symfony cheduled task of which the argument is applied for
     *
     * @var SymfonyScheduledTask
     *
     * @ORM\ManyToOne(targetEntity="Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTask", inversedBy="symfonyArguments")
     * @ORM\JoinColumn(name="symfony_scheduled_task_id", referencedColumnName="id")
     */
    protected $symfonyScheduledTask;

    /**
     * Get the ID of the Symfony scheduled task argument
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of the Symfony scheduled task argument
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the Symfony scheduled task argument
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of the Symfony scheduled task argument
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of the Symfony scheduled task argument
     * @param $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * Get the Symfony scheduled task linked to this argument
     *
     * @return SymfonyScheduledTask
     */
    public function getSymfonyScheduledTask()
    {
        return $this->symfonyScheduledTask;
    }

    /**
     * Set the Symfony scheduled task linked to this argument
     *
     * @param $symfonyScheduledTask
     */
    public function setSymfonyScheduledTask($symfonyScheduledTask)
    {
        $this->symfonyScheduledTask = $symfonyScheduledTask;
    }
}
