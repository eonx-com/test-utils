<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Vendor\Doctrine;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @coversNothing
 *
 * @SuppressWarnings(PHPMD.TooManyMethods) This class is implemented from a Doctrine interface
 * @SuppressWarnings(PHPMD.TooManyPublicMethods) This class is implemented from a Doctrine interface
 */
class EntityManagerStub implements EntityManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function beginTransaction()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function clear($objectName = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function contains($object)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function copy($entity, $deep = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createNamedNativeQuery($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createNamedQuery($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createNativeQuery($sql, ResultSetMapping $rsm)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($dql = '')
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createQueryBuilder()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function detach($object)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ShortVariable) Parameter is inherited from interface
     */
    public function find($className, $id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getCache()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getClassMetadata($className)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new Configuration();
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getEventManager()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getExpressionBuilder()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getHydrator($hydrationMode)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataFactory()
    {
        return new ClassMetadataFactory();
    }

    /**
     * {@inheritdoc}
     */
    public function getPartialReference($entityName, $identifier)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getProxyFactory()
    {
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ShortVariable) Parameter is inherited from interface
     */
    public function getReference($entityName, $id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository($className)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitOfWork()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function hasFilters()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function initializeObject($obj)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isFiltersStateClean()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isOpen()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function lock($entity, $lockMode, $lockVersion = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function merge($object)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function newHydrator($hydrationMode)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function persist($object)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function refresh($object)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function remove($object)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function rollback()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function transactional($func)
    {
    }
}
