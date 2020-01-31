<?php

namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class ScheduledEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cron_expression", type="string", length=20)
     */
    protected $cronExpression;

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
     * Get the value of Cron Expresion
     *
     * @return string
     */
    public function getCronExpression()
    {
        return $this->cronExpression;
    }

    /**
     * Set the value of Cron Expresion
     *
     * @param string cronExpression
     *
     * @return ScheduledEntity
     */
    public function setCronExpression($cronExpression)
    {
        $this->cronExpression = $cronExpression;

        return $this;
    }
}
