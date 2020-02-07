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
 * ScheduledEntity class.
 *
 * @ORM\Entity
 * @ORM\Table(name="scheduled_entity")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="scheduled_type", type="string")
 * @DiscriminatorParent()
 * @DiscriminatorEntry("self")
 */
abstract class ScheduledEntity
{
    /**
     * Unique ID.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Unix cron expression.
     *
     * @var string
     *
     * @ORM\Column(name="cron_expression", type="string", length=20)
     */
    protected $cronExpression;

    /**
     * ScheduledEntity constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of Cron Expresion.
     *
     * @return string
     */
    public function getCronExpression(): string
    {
        return $this->cronExpression;
    }

    /**
     * Set the value of Cron Expresion.
     *
     * @param string cronExpression
     *
     * @return $this
     */
    public function setCronExpression($cronExpression)
    {
        $this->cronExpression = $cronExpression;

        return $this;
    }
}
