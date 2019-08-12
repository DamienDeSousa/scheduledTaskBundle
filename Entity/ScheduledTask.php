<?php

/**
 * Represent a task to schedule
 *
 * @author Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 *
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScheduledTask class
 *
 * @ORM\Table(name="scheduled_task")
 * @ORM\Entity(repositoryClass="Dades\ScheduledTaskBundle\Repository\ScheduledTaskRepository")
 */
class ScheduledTask extends ScheduledEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="command", type="string", length=255)
     */
    protected $command;

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
}
