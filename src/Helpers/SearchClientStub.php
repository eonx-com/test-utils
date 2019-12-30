<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers;

use Eonx\TestUtils\Helpers\Interfaces\ClientStubInterface;
use LoyaltyCorp\Search\DataTransferObjects\ClusterHealth;

final class SearchClientStub implements ClientStubInterface
{
    /**
     * @var string[][]
     */
    private $aliases;

    /**
     * @var mixed[]
     */
    private $createdAliases = [];

    /**
     * @var mixed[]
     */
    private $createdIndices = [];

    /**
     * @var mixed[]
     */
    private $deletedAliases = [];

    /**
     * @var mixed[]
     */
    private $deletedIndices = [];

    /**
     * @var mixed[]
     */
    private $indices;

    /**
     * @var bool
     */
    private $isAlias;

    /**
     * @var bool
     */
    private $isIndex;

    /**
     * @var string[]
     */
    private $swappedAliases = [];

    /**
     * @var mixed[]
     */
    private $updatedIndices = [];

    /**
     * SearchClientStub constructor.
     *
     * @param bool|null $isAlias
     * @param bool|null $isIndex
     * @param mixed[]|null $indices
     * @param mixed[]|null $aliases
     */
    public function __construct(
        ?bool $isAlias = null,
        ?bool $isIndex = null,
        ?array $indices = null,
        ?array $aliases = null
    ) {
        $this->aliases = $aliases ?? [];
        $this->indices = $indices ?? [];
        $this->isAlias = $isAlias ?? false;
        $this->isIndex = $isIndex ?? false;
    }

    /**
     * {@inheritdoc}
     */
    public function bulkDelete(array $searchIds): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function bulkUpdate(array $updates): void
    {
        $this->updatedIndices[] = $updates;
    }

    /**
     * {@inheritdoc}}
     */
    public function count(string $index): int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function createAlias(string $indexName, string $aliasName): void
    {
        $this->createdAliases[] = $aliasName;
    }

    /**
     * {@inheritdoc}
     */
    public function createIndex(string $name, ?array $mappings = null, ?array $settings = null): void
    {
        $this->createdIndices[] = \compact('name', 'mappings', 'settings');
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAlias(array $aliases): void
    {
        foreach ($aliases as $alias) {
            $this->deletedAliases[] = $alias;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteIndex(string $name): void
    {
        $this->deletedIndices[] = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(?string $name = null): array
    {
        return $this->aliases;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAliases(): array
    {
        return $this->createdAliases;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedIndices(): array
    {
        return $this->createdIndices;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeletedAliases(): array
    {
        return $this->deletedAliases;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeletedIndices(): array
    {
        return $this->deletedIndices;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore Until an implementation exists.
     */
    public function getHealth(): ClusterHealth
    {
        return new ClusterHealth([]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIndices(?string $name = null): array
    {
        return $this->indices;
    }

    /**
     * Spy on alias that had its index swapped
     *
     * @return string[] Alias => Index
     */
    public function getSwappedAliases(): array
    {
        return $this->swappedAliases;
    }

    /**
     * Get list if indices updated.
     *
     * @return mixed[]
     */
    public function getUpdatedIndices(): array
    {
        return $this->updatedIndices;
    }

    /**
     * {@inheritdoc}
     */
    public function isAlias(string $name): bool
    {
        return $this->isAlias;
    }

    /**
     * {@inheritdoc}
     */
    public function isIndex(string $name): bool
    {
        return $this->isIndex;
    }

    /**
     * {@inheritdoc}
     */
    public function moveAlias(array $aliases): void
    {
        foreach ($aliases as $alias) {
            $this->swappedAliases[$alias['alias']] = $alias['index'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): void
    {
        $this->createdAliases = [];
        $this->createdIndices = [];
        $this->deletedAliases = [];
        $this->deletedIndices = [];
        $this->updatedIndices = [];
        $this->swappedAliases = [];
    }
}
