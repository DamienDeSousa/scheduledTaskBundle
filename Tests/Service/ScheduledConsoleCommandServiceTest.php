<?php
/**
 * Class used to unit tests the ScheduledConsoleCommandService.
 *
 * @author    Damien DE SOUSA <de.sousa.damien.pro@gmail.com>
 * @copyright 2020
 */
namespace Dades\ScheduledTaskBundle\Tests\Service;

use Dades\ScheduledTaskBundle\Repository\ScheduledCommandRepository;
use Dades\ScheduledTaskBundle\Service\ScheduledSymfonyCommandService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ScheduledConsoleCommandServiceTest.
 */
class ScheduledConsoleCommandServiceTest extends KernelTestCase
{
    /**
     * The project root directory.
     *
     * @var string
     */
    protected $projectDir;

    /**
     * The scheduled command type.
     *
     * @var string
     */
    protected $scheduledCommandType;

    /**
     * The mock of the ScheduledCommandRepository.
     *
     * @var ScheduledCommandRepository|MockObject
     */
    protected $scheduledCommandRepository;

    /**
     * The mock of the entity manager.
     *
     * @var EntityManager|MockObject
     */
    protected $entityManager;

    /**
     * Set attributes before launching tests.
     */
    public function setUp()
    {
        $kernel = self::bootKernel();
        $this->projectDir = $kernel->getProjectDir();
        $this->scheduledCommandType = $kernel->getContainer()
            ->getParameter('dades_scheduled_task_bundle.scheduled_command_type.console');
        $this->scheduledCommandRepository = $this->createMock(ScheduledCommandRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->scheduledCommandRepository);
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

        $this->assertEquals(
            $scheduledSymfonyCommandEntity->getScheduledCommandEntityType(),
            $this->scheduledCommandType
        );
    }

    /**
     * Test the creation of a ScheduledSymfonyCommandEntity.
     *
     * @throws \Exception
     */
    public function testIsDue()
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

    /**
     * Close objects to avoid memory leak.
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
    }
}
