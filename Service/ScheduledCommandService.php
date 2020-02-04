<?php


namespace Dades\ScheduledTaskBundle\Service;


use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ScheduledCommandService extends ScheduledEntityService
{

    /**
     * Runs anything runnable like Symfony commands, Unix/Windows commands
     *
     * @param ScheduledCommandEntity $scheduledCommandEntity
     * @param OutputInterface        $output
     * @param Application|null       $application
     */
    protected abstract function run(ScheduledCommandEntity $scheduledCommandEntity, $output, $application = null);

    /**
     * @param      $output
     * @param null $application
     */
    public function runAllScheduledCommand($output, $application = null)
    {
        /** @var ScheduledCommandEntity[] $scheduledCommandEntities */
        $scheduledCommandEntities = $this->getScheduledEntities();
        foreach ($scheduledCommandEntities as $scheduledCommandEntity) {
            $this->run($scheduledCommandEntity, $output, $application);
        }
    }
}
