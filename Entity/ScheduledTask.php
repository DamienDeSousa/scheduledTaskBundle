<?php

namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScheduledTask
 *
 * @ORM\Table(name="scheduled_task")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\ScheduledTaskRepository")
 *
 * Represent a task to schedule
 * @author Damien DE SOUSA
 */
class ScheduledTask
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="command", type="string", length=255)
     */
    private $command;

    /**
     * @var string
     *
     * @ORM\Column(name="cron_expression", type="string", length=20)
     */
    private $cronExpresion;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set command
     *
     * @param string $command
     *
     * @return ScheduledTask
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Get the value of Cron Expresion
     *
     * @return string
     */
    public function getCronExpresion()
    {
        return $this->cronExpresion;
    }

    /**
     * Set the value of Cron Expresion
     *
     * @param string cronExpresion
     *
     * @return self
     */
    public function setCronExpresion($cronExpresion)
    {
        $this->cronExpresion = $cronExpresion;

        return $this;
    }
}
