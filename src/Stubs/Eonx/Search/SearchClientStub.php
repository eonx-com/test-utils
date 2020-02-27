<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Eonx\Search;

use Eonx\TestUtils\Stubs\BaseStub;
use Eonx\TestUtils\Stubs\Interfaces\Eonx\Search\ClientStubInterface;
use LoyaltyCorp\Search\DataTransferObjects\ClusterHealth;

/**
 * @codeCoverageIgnore
 */
final class SearchClientStub extends BaseStub implements ClientStubInterface
{
    /**
     * {@inheritdoc}
     */
    public function bulk(array $actions): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function count(string $index): int
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), 0);
    }

    /**
     * {@inheritdoc}
     */
    public function createAlias(string $indexName, string $aliasName): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function createIndex(string $name, ?array $mappings = null, ?array $settings = null): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAlias(array $aliases): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteIndex(string $name): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(?string $name = null): array
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), []);
    }

    /**
     * {@inheritdoc}
     */
    public function getBulkActions(): array
    {
        $actions = [];

        foreach ($this->getCalls('bulk') as $call) {
            $actions[] = $call['actions'];
        }

        return \array_merge(...$actions);
    }

    /**
     * {@inheritdoc}
     */
    public function getHealth(): ClusterHealth
    {
        return $this->doStubCall(__FUNCTION__, [], new ClusterHealth([]));
    }

    /**
     * {@inheritdoc}
     */
    public function getIndices(?string $name = null): array
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), []);
    }

    /**
     * {@inheritdoc}
     */
    public function isAlias(string $name): bool
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), false);
    }

    /**
     * {@inheritdoc}
     */
    public function isIndex(string $name): bool
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), false);
    }

    /**
     * {@inheritdoc}
     */
    public function moveAlias(array $aliases): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
}
