<?php

namespace Dades\ScheduledTaskBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dades\ScheduledTaskBundle\Service\ScheduledTaskService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Dades\ScheduledTaskBundle\Exception\BadCommandException;
use Cron\CronExpression;

class DefaultController extends Controller
{
    /**
     * @Route("/dades", name="dadespage")
     */
    public function indexAction(ScheduledTaskService $scheduledTaskService)
    {
        //$task1 = $scheduledTaskService->create();
        //$task1->setCommand("notepad.exe")->setCronExpresion("*/5 * * * *");

        //$task2 = $scheduledTaskService->create();
        //$task2->setCommand("calc")->setCronExpresion("30 * * * *");

        /*$task3 = $scheduledTaskService->create();
        $task3->setCommand("phpp")->setCronExpresion("0 * * * *");*/

        //$scheduledTaskService->save($task1);
        //$scheduledTaskService->save($task2);
        //$scheduledTaskService->save($task3);

        /*$task3 = $scheduledTaskService->getScheduledTask(1);
        $scheduledTaskService->delete($task3);*/

        //$task4 = $scheduledTaskService->create();
        //$task4->setCommand("php --vers")->setCronExpresion("*/5 * * * *");

        //$scheduledTaskService->save($task4);

        $task = $scheduledTaskService->getScheduledTask(3);
        $cron = CronExpression::factory($task->getCronExpresion());
        echo $cron->getNextRunDate()->format('Y-m-d H:i:s');

        return new Response($cron->getNextRunDate()->format('Y-m-d H:i:s'));
    }
}
//https://sites.google.com/site/ballif1073/windows/taches-planifiees

//schtasks /Create /TN nom /SC ONCE /TR notepad.exe /ST 23:33:00
//schtasks /Delete /TN nom

//schtasks /Create /TN nom2 /SC ONCE /TR "php D:\symfonyProjects\3.4\account-book\bin\console doctrine:schema:update --force" /ST 20:26:00
//https://packagist.org/packages/lavary/crunz (cron for unix kernel)

/**
 * Ajouter la compatibilité sur Unix / Linux
 * https://docs.microsoft.com/en-us/windows-server/administration/windows-commands/schtasks#BKMK_create
 */
