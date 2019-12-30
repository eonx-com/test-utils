<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases\Integration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Eonx\TestUtils\TestCases\TestCase;

/**
 * This test case exists to do integration tests against the Doctrine ORM where a full
 * application does not need to be booted.
 *
 * By default, this TestCase will load entities in the PROJECT_PATH/tests/Integration/Fixtures
 * directory, but can be changed by overriding the getEntityPaths() function.
 *
 * @coversNothing
 */
class DoctrineORMTestCase extends TestCase
{
    /**
     * SQL queries to create database schema.
     *
     * @var string
     */
    private static $sql;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface|null
     */
    private $entityManager;

    /**
     * Whether the database has been seeded or not.
     *
     * @var bool
     */
    private $seeded = false;

    /**
     * Get doctrine entity manager instance.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     *
     * @throws \Doctrine\ORM\ORMException
     *
     * @SuppressWarnings(PHPMD.StaticAccess) Static access to entity manager required to create instance
     */
    protected function createDoctrineEntityManager(): EntityManagerInterface
    {
        $paths = $this->getEntityPaths();

        $setup = new Setup();
        $config = $setup::createAnnotationMetadataConfiguration($paths, true, null, null, false);

        $dbParams = [
            'driver' => 'pdo_sqlite',
            'memory' => true
        ];

        return EntityManager::create($dbParams, $config);
    }

    /**
     * Lazy load database schema only when required.
     *
     * @return void
     */
    protected function createSchema(): void
    {
        // If schema is already created, return
        if ($this->seeded === true) {
            // @codeCoverageIgnoreStart
            // Unable to make assertions against the services/classes this method calls to ensure
            // that nothing happened.
            return;
            // @codeCoverageIgnoreEnd
        }

        // Create schema
        try {
            $this->entityManager = $this->createDoctrineEntityManager();

            // If schema hasn't been defined, define it, this will happen once per run
            if (self::$sql === null) {
                $tool = new SchemaTool($this->entityManager);
                $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
                self::$sql = \implode(';', $tool->getCreateSchemaSql($metadata));
            }

            $this->entityManager->getConnection()->exec(self::$sql);
            // @codeCoverageIgnoreStart
        } catch (\Exception $exception) {
            // Testing this exception/failure requires invalid entities to be present for the SchemaTool
            // to throw.
            self::fail(\sprintf('Exception thrown when creating database schema: %s', $exception->getMessage()));
            // @codeCoverageIgnoreEnd
        }

        $this->seeded = true;
    }

    /**
     * Get entity manager.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        $this->createSchema();

        if (($this->entityManager instanceof EntityManagerInterface) === false) {
            // @codeCoverageIgnoreStart
            // Only here to appease the type checker: createSchema will always set an entity manager
            // or fail.
            self::fail('Failed to create an entity manager');
            // @codeCoverageIgnoreEnd
        }

        return $this->entityManager;
    }

    /**
     * Returns an array of paths where entities should be found.
     *
     * @return string[]
     *
     * @codeCoverageIgnore Unable to test this with coverage as this project does not have a tests/Integration/Fixtures
     *   directory.
     */
    protected function getEntityPaths(): array
    {
        return [
            \implode(\DIRECTORY_SEPARATOR, [$this->getProjectPath(), 'tests', 'Integration', 'Fixtures'])
        ];
    }

    /**
     * Unsets the entity manager at the end of a test.
     *
     * @return void
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function tearDown(): void
    {
        $this->entityManager = null;
        $this->seeded = false;
    }
}
