<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\TestCases\Integration;

use Doctrine\ORM\EntityManagerInterface;
use Eonx\TestUtils\TestCases\Integration\DoctrineORMTestCase;

/**
 * @coversNothing
 */
class DoctrineORMTestCaseStub extends DoctrineORMTestCase
{
    /**
     * @var string[]
     */
    private $paths = [];

    /**
     * {@inheritdoc}
     *
     * Overridden to allow getting the entity manager from the test case.
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return parent::getEntityManager();
    }

    /**
     * Sets paths. Should be called before calling getEntityManager().
     *
     * @param string[] $paths
     *
     * @return void
     */
    public function setPaths(array $paths): void
    {
        $this->paths = $paths;
    }

    /**
     * {@inheritdoc}
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected function getEntityPaths(): array
    {
        return $this->paths;
    }
}
