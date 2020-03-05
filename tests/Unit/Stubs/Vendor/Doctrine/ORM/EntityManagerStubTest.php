<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Stubs\Vendor\Doctrine\ORM;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;
use Eonx\TestUtils\Stubs\Vendor\Doctrine\ORM\EntityManagerStub;
use stdClass;
use Tests\Eonx\TestUtils\TestCases\StubTestCase;

/**
 * @covers \Eonx\TestUtils\Stubs\Vendor\Doctrine\ORM\EntityManagerStub
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) Required to test
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength) Required to test
 */
class EntityManagerStubTest extends StubTestCase
{
    /**
     * {@inheritdoc}
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getMethodExpectations(): iterable
    {
        $entityManager = new EntityManagerStub();

        yield 'beginTransaction' => [
            'method' => 'beginTransaction',
            'args' => [],
            'return' => null
        ];

        yield 'clear' => [
            'method' => 'clear',
            'args' => ['objectName' => 'objectName'],
            'return' => null
        ];

        yield 'close' => [
            'method' => 'close',
            'args' => [],
            'return' => null
        ];

        yield 'commit' => [
            'method' => 'commit',
            'args' => [],
            'return' => null
        ];

        yield 'contains' => [
            'method' => 'contains',
            'args' => ['object' => new stdClass()],
            'return' => false
        ];

        yield 'createNamedNativeQuery' => [
            'method' => 'createNamedNativeQuery',
            'args' => ['name' => 'name'],
            'return' => new NativeQuery($entityManager)
        ];

        yield 'createNamedQuery' => [
            'method' => 'createNamedQuery',
            'args' => ['name' => 'name'],
            'return' => new Query($entityManager)
        ];

        yield 'createNativeQuery' => [
            'method' => 'createNativeQuery',
            'args' => [
                'sql' => 'sql',
                'rsm' => new Query\ResultSetMapping()
            ],
            'return' => new NativeQuery($entityManager)
        ];

        yield 'createQuery' => [
            'method' => 'createQuery',
            'args' => [
                'dql' => 'dql',
            ],
            'return' => new Query($entityManager)
        ];

        yield 'createQueryBuilder' => [
            'method' => 'createQueryBuilder',
            'args' => [],
            'return' => new QueryBuilder($entityManager)
        ];

        yield 'detach' => [
            'method' => 'detach',
            'args' => [
                'object' => new stdClass()
            ],
            'return' => null
        ];

        yield 'find' => [
            'method' => 'find',
            'args' => [
                'className' => stdClass::class,
                'id' => 5
            ],
            'return' => null
        ];

        yield 'flush' => [
            'method' => 'flush',
            'args' => [],
            'return' => null
        ];

        yield 'getCache' => [
            'method' => 'getCache',
            'args' => [],
            'return' => null
        ];

        yield 'getClassMetadata' => [
            'method' => 'getClassMetadata',
            'args' => ['className' => stdClass::class],
            'return' => new ClassMetadata(stdClass::class)
        ];

        yield 'getConfiguration' => [
            'method' => 'getConfiguration',
            'args' => [],
            'return' => new Configuration()
        ];

        yield 'getConnection' => [
            'method' => 'getConnection',
            'args' => [],
            'return' => new Connection([], new Driver())
        ];

        yield 'getEventManager' => [
            'method' => 'getEventManager',
            'args' => [],
            'return' => new EventManager()
        ];

        yield 'getExpressionBuilder' => [
            'method' => 'getExpressionBuilder',
            'args' => [],
            'return' => new Query\Expr()
        ];

        yield 'getFilters' => [
            'method' => 'getFilters',
            'args' => [],
            'return' => new Query\FilterCollection($entityManager)
        ];

        yield 'getMetadataFactory' => [
            'method' => 'getMetadataFactory',
            'args' => [],
            'return' => new ClassMetadataFactory()
        ];

        yield 'getPartialReference' => [
            'method' => 'getPartialReference',
            'args' => [
                'entityName' => stdClass::class,
                'identifier' => 7
            ],
            'return' => new stdClass()
        ];

        yield 'getReference' => [
            'method' => 'getReference',
            'args' => [
                'entityName' => stdClass::class,
                'id' => 7
            ],
            'return' => new stdClass()
        ];

        yield 'getRepository' => [
            'method' => 'getRepository',
            'args' => [
                'className' => stdClass::class,
            ],
            'return' => new EntityRepository($entityManager, new ClassMetadata(stdClass::class))
        ];

        yield 'getUnitOfWork' => [
            'method' => 'getUnitOfWork',
            'args' => [],
            'return' => new UnitOfWork($entityManager)
        ];

        yield 'hasFilters' => [
            'method' => 'hasFilters',
            'args' => [],
            'return' => false
        ];

        yield 'initializeObject' => [
            'method' => 'initializeObject',
            'args' => ['obj' => new stdClass()],
            'return' => null
        ];

        yield 'isFiltersStateClean' => [
            'method' => 'isFiltersStateClean',
            'args' => [],
            'return' => true
        ];

        yield 'isOpen' => [
            'method' => 'isOpen',
            'args' => [],
            'return' => true
        ];

        yield 'lock' => [
            'method' => 'lock',
            'args' => [
                'entity' => new stdClass(),
                'lockMode' => 'purple',
                'lockVersion' => 69
            ],
            'return' => null
        ];

        $stdClass = new stdClass();

        yield 'merge' => [
            'method' => 'merge',
            'args' => [
                'object' => $stdClass
            ],
            'return' => $stdClass
        ];

        yield 'persist' => [
            'method' => 'persist',
            'args' => [
                'object' => $stdClass
            ],
            'return' => null
        ];

        yield 'remove' => [
            'method' => 'remove',
            'args' => [
                'object' => $stdClass
            ],
            'return' => null
        ];

        yield 'refresh' => [
            'method' => 'refresh',
            'args' => [
                'object' => $stdClass
            ],
            'return' => null
        ];

        yield 'rollback' => [
            'method' => 'rollback',
            'args' => [],
            'return' => null
        ];

        yield 'transactional' => [
            'method' => 'transactional',
            'args' => ['func' => static function (): void {
            }],
            'return' => null
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getStubClass(): string
    {
        return EntityManagerStub::class;
    }

    /**
     * Tests that copy returns a new object.
     *
     * @return void
     */
    public function testCopy(): void
    {
        $stub = new EntityManagerStub();

        $stdClass = new stdClass();

        $result = $stub->copy($stdClass);

        self::assertNotSame($stdClass, $result);
    }
}
