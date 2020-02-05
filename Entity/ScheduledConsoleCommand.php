<?php

/**
 * Represent a task to schedule
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2019
 */

namespace Dades\ScheduledTaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScheduledConsoleCommand class
 *
 * @ORM\Entity
 * @ORM\Table(name="scheduled_console_command_entity")
 * @ORM\DiscriminatorEntry(value="scheduled_console_command_entity")
 */
class ScheduledConsoleCommand extends ScheduledCommandEntity
{

}
