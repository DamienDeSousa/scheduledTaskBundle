<?php
/**
 *
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
     * @var string
     *
     * @ORM\Column(name="value", type="string")
     */
    protected $value;

    /**
     * XXX
     *
     * @var SymfonyScheduledTask
     *
     * @ORM\ManyToOne(targetEntity="Dades\ScheduledTaskBundle\Entity\SymfonyScheduledTask", inversedBy="symfonyArguments")
     * @ORM\JoinColumn(name="symfony_scheduled_task_id", referencedColumnName="id")
     */
    protected $symfonyScheduledTask;

    public function getId()
    {
        return $id;
    }

    public function getName()
    {
        return $name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getSymfonyScheduledTask()
    {
        return $this->symfonyScheduledTask;
    }

    public function setSymfonyScheduledTask($symfonyScheduledTask)
    {
        $this->symfonyScheduledTask = $symfonyScheduledTask;
    }
}
