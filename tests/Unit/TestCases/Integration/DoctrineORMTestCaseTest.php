<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\Integration;

use Eonx\TestUtils\TestCases\UnitTestCase;
use Tests\Eonx\TestUtils\Stubs\TestCases\Integration\DoctrineORMTestCaseStub;

/**
 * @covers \Eonx\TestUtils\TestCases\Integration\DoctrineORMTestCase
 */
class DoctrineORMTestCaseTest extends UnitTestCase
{
    /**
     * Tests that the test case correctly builds and returns an entity manager.
     *
     * @return void
     */
    public function testEntityManagerCreation(): void
    {
        $testCase = $this->createTestCaseUnderTest();

        $testCase->getEntityManager();

        // No exceptions occurred.
        $this->addToAssertionCount(1);
    }

    /**
     * Tests that the test case correctly builds and returns the same entity manager across multiple calls.
     *
     * @return void
     */
    public function testEntityManagerCreationNoRecreation(): void
    {
        $testCase = $this->createTestCaseUnderTest();

        $entityManager1 = $testCase->getEntityManager();
        $entityManager2 = $testCase->getEntityManager();

        self::assertSame($entityManager1, $entityManager2);
    }

    /**
     * Tests that the test case tears down correctly.
     *
     * @return void
     */
    public function testEntityManagerTeardown(): void
    {
        $testCase = $this->createTestCaseUnderTest();

        $entityManager1 = $testCase->getEntityManager();
        $testCase->tearDown();
        $entityManager2 = $testCase->getEntityManager();

        self::assertNotSame($entityManager1, $entityManager2);
    }

    /**
     * Returns a DoctrineORMTestCase that has its entity paths configured for this unit test.
     *
     * @return \Tests\Eonx\TestUtils\Stubs\TestCases\Integration\DoctrineORMTestCaseStub
     */
    private function createTestCaseUnderTest(): DoctrineORMTestCaseStub
    {
        $testCase = new DoctrineORMTestCaseStub();
        $testCase->setPaths([
            \implode(\DIRECTORY_SEPARATOR, [\realpath(__DIR__), 'Fixtures', 'ORM'])
        ]);

        return $testCase;
    }
}
