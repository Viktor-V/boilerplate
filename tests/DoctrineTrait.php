<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

trait DoctrineTrait
{
    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();

        $kernel = static::$booted
            ? self::$kernel
            : self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        parent::tearDown();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}
