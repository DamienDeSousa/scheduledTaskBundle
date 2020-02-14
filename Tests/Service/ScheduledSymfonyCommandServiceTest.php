<?php

namespace Dades\ScheduledTaskBundle\Tests\Service;

use Dades\ScheduledTaskBundle\Repository\ScheduledCommandRepository;
use Dades\ScheduledTaskBundle\Service\ScheduledSymfonyCommandService;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ScheduledSymfonyCommandServiceTest.
 */
class ScheduledSymfonyCommandServiceTest extends KernelTestCase
{
    public function testCreate()
    {
        $kernel = self::bootKernel();
        $projectDir = $kernel->getProjectDir();
        $scheduledCommandType = $kernel->getContainer()
            ->getParameter('dades_scheduled_task_bundle.scheduled_command_type.symfony');
        $scheduledCommandRepository = $this->createMock(ScheduledCommandRepository::class);
        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($scheduledCommandRepository);
        $scheduledSymfonyCommandService = new ScheduledSymfonyCommandService(
            $entityManager,
            $scheduledCommandRepository,
            $projectDir,
            $scheduledCommandType
        );
        $scheduledSymfonyCommandEntity = $scheduledSymfonyCommandService->create();

        $this->assertEquals($scheduledCommandType, $scheduledSymfonyCommandEntity->getScheduledCommandEntityType());
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
    // test save, update, delete
}
