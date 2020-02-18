<?php

namespace Dades\ScheduledTaskBundle\Tests\Service;

use Dades\ScheduledTaskBundle\Entity\ScheduledCommandEntity;
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
    protected $projectDir;
    protected $scheduledCommandType;
    protected $scheduledCommandRepository;
    protected $entityManager;

    public function setUp()
    {
        $kernel = self::bootKernel();
        $this->projectDir = $kernel->getProjectDir();
        $this->scheduledCommandType = $kernel->getContainer()
            ->getParameter('dades_scheduled_task_bundle.scheduled_command_type.symfony');
        $this->scheduledCommandRepository = $this->createMock(ScheduledCommandRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->scheduledCommandRepository);
    }

    public function testConstruct()
    {
        try {
            $scheduledSymfonyCommandService = new ScheduledSymfonyCommandService(
                $this->entityManager,
                $this->scheduledCommandRepository,
                $this->projectDir,
                $this->scheduledCommandType
            );
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false, $e->getMessage());
        }
    }

    public function testCreate()
    {
        $scheduledSymfonyCommandService = new ScheduledSymfonyCommandService(
            $this->entityManager,
            $this->scheduledCommandRepository,
            $this->projectDir,
            $this->scheduledCommandType
        );
        $scheduledSymfonyCommandEntity = $scheduledSymfonyCommandService->create();
        $scheduledSymfonyCommandEntity->setCronExpression('*/1 * * * *');

        $this->assertTrue($scheduledSymfonyCommandService->isDue($scheduledSymfonyCommandEntity));
    }
    
    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}
