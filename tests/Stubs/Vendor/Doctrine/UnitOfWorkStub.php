<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Vendor\Doctrine;

use Doctrine\ORM\UnitOfWork;

/**
 * @coversNothing
 */
class UnitOfWorkStub extends UnitOfWork
{
    /**
     * All pending collection deletions.
     *
     * @var mixed[]
     */
    private $collectionDeletions;

    /**
     * All pending collection updates.
     *
     * @var mixed[]
     */
    private $collectionUpdates;

    /**
     * A list of all pending entity deletions.
     *
     * @var mixed[]
     */
    private $entityDeletions;

    /**
     * A list of all pending entity insertions.
     *
     * @var mixed[]
     */
    private $entityInsertions;

    /**
     * A list of all pending entity updates.
     *
     * @var mixed[]
     */
    private $entityUpdates;

    /**
     * UnitOfWorkStub constructor.
     *
     * @param mixed[] $collectionDeletions
     * @param mixed[] $collectionUpdates
     * @param mixed[] $entityDeletions
     * @param mixed[] $entityInsertions
     * @param mixed[] $entityUpdates
     */
    public function __construct(
        array $collectionDeletions = [],
        array $collectionUpdates = [],
        array $entityDeletions = [],
        array $entityInsertions = [],
        array $entityUpdates = []
    ) {
        $this->collectionDeletions = $collectionDeletions;
        $this->collectionUpdates = $collectionUpdates;
        $this->entityDeletions = $entityDeletions;
        $this->entityInsertions = $entityInsertions;
        $this->entityUpdates = $entityUpdates;

        parent::__construct(new EntityManagerStub($this));
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledCollectionDeletions()
    {
        return $this->collectionDeletions;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledCollectionUpdates()
    {
        return $this->collectionUpdates;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledEntityDeletions()
    {
        return $this->entityDeletions;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledEntityInsertions()
    {
        return $this->entityInsertions;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledEntityUpdates()
    {
        return $this->entityUpdates;
    }
}
