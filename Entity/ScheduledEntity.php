<?php
/**
 * Defines all the required attributes that a scheduled task must have.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Levelab\Doctrine\DiscriminatorBundle\Annotation\DiscriminatorEntry;
use Levelab\Doctrine\DiscriminatorBundle\Annotation\DiscriminatorParent;

/**
 * ScheduledEntity class
 *
 * @ORM\Entity
 * @ORM\Table(name="scheduled_entity")
 * @DiscriminatorParent()
 * @DiscriminatorEntry("self")
 */
abstract class ScheduledEntity
{
    /**
     * Unique ID
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Unix cron expression
     *
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
