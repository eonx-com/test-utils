<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Vendor\Doctrine\ORM;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Cache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataFactory as ORMClassMetadataFactory;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\Mapping\ClassMetadataFactory;
use Eonx\TestUtils\Stubs\BaseStub;

/**
 * @SuppressWarnings(PHPMD) Interface is not under our control.
 */
class EntityManagerStub extends BaseStub implements EntityManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function beginTransaction(): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function clear($objectName = null): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function close(): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function commit(): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function contains($object): bool
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, false, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function copy($entity, $deep = null)
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, clone $entity, \func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function createNamedNativeQuery($name): NativeQuery
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, self::NOT_PROVIDED, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function createNamedQuery($name): Query
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new Query($this), \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function createNativeQuery($sql, ResultSetMapping $rsm): NativeQuery
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new NativeQuery($this), \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function createQuery($dql = null): Query
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new Query($this), \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function createQueryBuilder(): QueryBuilder
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new QueryBuilder($this), \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     *
     * @deprecated See EntityManager's deprecation.
     */
    public function detach($object): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function find($className, $id)
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function flush(): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function getCache(): ?Cache
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }

    /**
     * Not inherited due to weirdness with inheritdoc.
     *
     * @param mixed $className
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getClassMetadata($className): ClassMetadata
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new ClassMetadata($className));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): Configuration
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new Configuration());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConnection(): Connection
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, self::NOT_PROVIDED, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEventManager(): EventManager
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new EventManager());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExpressionBuilder(): Query\Expr
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new Query\Expr());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFilters(): Query\FilterCollection
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new Query\FilterCollection($this));
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     *
     * @deprecated
     */
    public function getHydrator($hydrationMode): AbstractHydrator
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMetadataFactory(): ClassMetadataFactory
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new ORMClassMetadataFactory(), \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPartialReference($entityName, $identifier)
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function getProxyFactory(): ProxyFactory
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReference($entityName, $id)
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }

    /**
     * {@inheritdoc}
     *
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function getRepository($className)
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUnitOfWork(): UnitOfWork
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, new UnitOfWork($this), \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasFilters(): bool
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, false, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function initializeObject($obj): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function isFiltersStateClean(): bool
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, true, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function isOpen(): bool
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, true, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function lock($entity, $lockMode, $lockVersion = null): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function merge($object)
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, $object, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function newHydrator($hydrationMode): AbstractHydrator
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, self::NOT_PROVIDED, \func_get_args());
    }
    
    /**
     * {@inheritdoc}
     */
    public function persist($object): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function refresh($object): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function remove($object): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function rollback(): void
    {
        $this->saveCallsAndThrow(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function transactional($func)
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, null, \func_get_args());
    }
}
