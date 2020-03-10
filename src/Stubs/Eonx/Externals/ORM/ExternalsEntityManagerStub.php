<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Eonx\Externals\ORM;

use EoneoPay\Externals\ORM\Interfaces\EntityInterface;
use EoneoPay\Externals\ORM\Interfaces\EntityManagerInterface;
use EoneoPay\Externals\ORM\Interfaces\Query\FilterCollectionInterface;
use Eonx\TestUtils\Stubs\BaseStub;

/**
 * @codeCoverageIgnore
 */
final class ExternalsEntityManagerStub extends BaseStub implements EntityManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByIds(string $class, array $ids): array
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), []);
    }

    /**
     * {@inheritdoc}
     */
    public function flush(): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): FilterCollectionInterface
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository(string $class)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function merge(EntityInterface $entity): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function persist(EntityInterface $entity): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EntityInterface $entity): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }
}
