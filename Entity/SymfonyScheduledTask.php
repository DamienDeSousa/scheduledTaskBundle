<?php

namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Undocumented class
 *
 * @ORM\Table(name="symfony_scheduled_task")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\SymfonyScheduledTaskRepository")
 */
class SymfonyScheduledTask extends ScheduledEntity
{
    /**
     * Undocumented variable
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * Undocumented variable
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *  targetEntity="Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTaskArgument",
     *  mappedBy="symfonyScheduledTask",
     *  cascade={"persist", "remove"})
     */
    protected $arguments;

    public function __construct()
    {
        $this->arguments = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function addArgument($argument)
    {
        $argument->setSymfonyScheduledTask($this);
        $this->arguments[] = $argument;
    }

    /**
     * Undocumented function
     *
     * @param SymfonyScheduledTaskArgument $argument
     */
    public function removeArgument($argument)
    {
        $argument->setSymfonyScheduledTask(null);
        $this->arguments->removeElement($argument);
    }
}
