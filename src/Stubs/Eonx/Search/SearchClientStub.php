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
        $this->saveCalls(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function count(string $index): int
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function createAlias(string $indexName, string $aliasName): void
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function createIndex(string $name, ?array $mappings = null, ?array $settings = null): void
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAlias(array $aliases): void
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteIndex(string $name): void
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(?string $name = null): array
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, []);
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
        return $this->returnOrThrowResponse(__FUNCTION__, new ClusterHealth([]));
    }

    /**
     * {@inheritdoc}
     */
    public function getIndices(?string $name = null): array
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, []);
    }

    /**
     * {@inheritdoc}
     */
    public function isAlias(string $name): bool
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, false);
    }

    /**
     * {@inheritdoc}
     */
    public function isIndex(string $name): bool
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());

        return $this->returnOrThrowResponse(__FUNCTION__, false);
    }

    /**
     * {@inheritdoc}
     */
    public function moveAlias(array $aliases): void
    {
        $this->saveCalls(__FUNCTION__, \get_defined_vars());
    }
}
