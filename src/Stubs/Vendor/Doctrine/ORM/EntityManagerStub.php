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
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function clear($objectName = null): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function close(): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function commit(): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function contains($object): bool
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), false);
    }
    
    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function copy($entity, $deep = null)
    {
        $clone = static function ($entity) {
            return clone $entity;
        };

        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), $clone);
    }

    /**
     * {@inheritdoc}
     */
    public function createNamedNativeQuery($name): NativeQuery
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function createNamedQuery($name): Query
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new Query($this));
    }
    
    /**
     * {@inheritdoc}
     */
    public function createNativeQuery($sql, ResultSetMapping $rsm): NativeQuery
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new NativeQuery($this));
    }
    
    /**
     * {@inheritdoc}
     */
    public function createQuery($dql = null): Query
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new Query($this));
    }
    
    /**
     * {@inheritdoc}
     */
    public function createQueryBuilder(): QueryBuilder
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new QueryBuilder($this));
    }
    
    /**
     * {@inheritdoc}
     *
     * @deprecated See EntityManager's deprecation.
     */
    public function detach($object): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function find($className, $id)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function flush(): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function getCache(): ?Cache
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
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
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new ClassMetadata($className));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): Configuration
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new Configuration());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConnection(): Connection
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEventManager(): EventManager
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new EventManager());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExpressionBuilder(): Query\Expr
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new Query\Expr());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFilters(): Query\FilterCollection
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new Query\FilterCollection($this));
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
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMetadataFactory(): ClassMetadataFactory
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new ORMClassMetadataFactory());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPartialReference($entityName, $identifier)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function getProxyFactory(): ProxyFactory
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReference($entityName, $id)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     *
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function getRepository($className)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUnitOfWork(): UnitOfWork
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new UnitOfWork($this));
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasFilters(): bool
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), false);
    }
    
    /**
     * {@inheritdoc}
     */
    public function initializeObject($obj): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function isFiltersStateClean(): bool
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function isOpen(): bool
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function lock($entity, $lockMode, $lockVersion = null): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function merge($object)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), $object);
    }
    
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function newHydrator($hydrationMode): AbstractHydrator
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }
    
    /**
     * {@inheritdoc}
     */
    public function persist($object): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function refresh($object): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function remove($object): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rollback(): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function transactional($func)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }
}
