<?php
/**
 * Entity that represents a Symfony scheduled task
 *
 * @author    Damien DE SOUSA
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SymfonyScheduledTask class
 *
 * @ORM\Table(name="symfony_scheduled_task")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\SymfonyScheduledTaskRepository")
 */
class SymfonyScheduledTask extends ScheduledEntity
{
    /**
     * The name of the Symfony task
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * The arguments used for this task
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *  targetEntity="Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTaskArgument",
     *  mappedBy="symfonyScheduledTask",
     *  cascade={"persist", "remove"})
     */
    protected $arguments;

    /**
     * SymfonyScheduledTask constructor.
     */
    public function __construct()
    {
        $this->arguments = new ArrayCollection();
    }

    /**
     * Get the name of the Symfony scheduled task
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the Symfony scheduled task
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the arguments of the Symfony scheduled task
     * @return ArrayCollection
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Add an argument to the Symfony scheduled task
     * @param SymfonyScheduledTaskArgument $argument
     */
    public function addArgument(SymfonyScheduledTaskArgument $argument)
    {
        $argument->setSymfonyScheduledTask($this);
        $this->arguments[] = $argument;
    }

    /**
     * Remove an argument to the Symfony scheduled task
     *
     * @param SymfonyScheduledTaskArgument $argument
     */
    public function removeArgument(SymfonyScheduledTaskArgument $argument)
    {
        $argument->setSymfonyScheduledTask(null);
        $this->arguments->removeElement($argument);
    }
}
