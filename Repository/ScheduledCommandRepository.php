<?php
/**
 * Repository used to query scheduled command entities.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Repository;

use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ScheduledCommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, $entityClass)
    {
        parent::__construct($registry, ScheduledCommandEntity::class);
    }
}
