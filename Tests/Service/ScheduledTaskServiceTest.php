<?php

namespace Dades\ScheduledTaskBundle\Tests\Service;

use Dades\ScheduledTaskBundle\Service\ScheduledEntityService;
use Dades\ScheduledTaskBundle\Entity\ScheduledTask;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Dades\ScheduledTaskBundle\Exception\NoSuchEntityException;

class ScheduledTaskServiceTest extends KernelTestCase
{
    /**
     * Entity Manager
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * Test Create method
     */
    public function testCreate()
    {
        $scheduledTaskService = new ScheduledEntityService($this->entityManager);
        $scheduledTask = $scheduledTaskService->create();

        $this->assertNotNull($scheduledTask);
    }

    /**
     * Test save method
     */
    public function testSave()
    {
        $scheduledTaskService = new ScheduledEntityService($this->entityManager);
        $scheduledTask = $scheduledTaskService->create();
        $scheduledTask->setCronExpression('*/5 * * * *');
        $scheduledTask->setCommand('php -v');
        $scheduledTaskService->save($scheduledTask);

        $this->assertNotNull($scheduledTask->getId());
    }

    /**
     * Test isDue method
     */
    public function testIsDue()
    {
        $scheduledTaskService = new ScheduledEntityService($this->entityManager);
        $scheduledTask = $scheduledTaskService->create();
        $scheduledTask->setCronExpression('* * * * *');
        $scheduledTask->setCommand('php -v');

        $this->assertTrue($scheduledTaskService->isDue($scheduledTask));
    }

    /**
     * Test update method
     */
    public function testUpdate()
    {
        $repository = $this->entityManager
            ->getRepository(ScheduledTask::class);
        $scheduledTask = $repository->findOneBy(['command' => 'php -v']);
        $scheduledTask->setCronExpression('*/2 * * * *');

        $this->assertEquals($scheduledTask->getCronExpression(), '*/2 * * * *');
    }

    /**
     * Test delete method
     */
    public function testDelete()
    {
        $this->expectException(NoSuchEntityException::class);

        $repository = $this->entityManager
            ->getRepository(ScheduledTask::class);
        $scheduledTask = $repository->findOneBy(['command' => 'php -v']);
        $id = $scheduledTask->getId();
        $scheduledTaskService = new ScheduledEntityService($this->entityManager);
        $scheduledTaskService->delete($scheduledTask);
        $removedTask = $scheduledTaskService->getScheduledEntity($id);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
