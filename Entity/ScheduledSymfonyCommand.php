<?php
/**
 * Entity that represents a Symfony scheduled task.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Levelab\Doctrine\DiscriminatorBundle\Annotation\DiscriminatorEntry;

/**
 * ScheduledSymfonyCommand class.
 *
 * @ORM\Entity
 * @ORM\Table(name="scheduled_symfony_command_entity")
 * @DiscriminatorEntry(value="scheduled_symfony_command_entity")
 */
class ScheduledSymfonyCommand extends ScheduledCommandEntity
{

}
