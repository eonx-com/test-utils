<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Constraint\Constraint;
use SebastianBergmann\Comparator\ComparisonFailure;

class DoctrineUnitOfWorkEmpty extends Constraint
{
    /**
     * {@inheritdoc}
     */
    public function evaluate($other, string $description = '', bool $returnResult = false)
    {
        if ($other instanceof UnitOfWork === false) {
            throw new AssertionFailedError(
                'Supplied object is not a valid UnitOfWork instance.'
            );
        }

        /**
         * @var \Doctrine\ORM\UnitOfWork $other
         *
         * @see https://youtrack.jetbrains.com/issue/WI-37859 - typehint required until PhpStorm recognises === check
         */
        $pendingChanges = [
            'scheduled collection deletions' => $other->getScheduledCollectionDeletions(),
            'scheduled collection updates' => $other->getScheduledCollectionUpdates(),
            'scheduled entity deletions' => $other->getScheduledEntityDeletions(),
            'scheduled entity insertions' => $other->getScheduledEntityInsertions(),
            'scheduled entity updates' => $other->getScheduledEntityUpdates()
        ];

        // Loop through the different scheduled types from unit of work so more context can be provided within failure
        foreach ($pendingChanges as $work => $entities) {
            // No entities is good, unit of work has nothing left to do
            if ($entities === []) {
                unset($pendingChanges[$work]);
                continue;
            }

            $pendingChanges[$work] = \array_map('get_class', $entities);
        }

        // if return result is true, return based on if pending changes are empty.
        if ($returnResult === true) {
            return \count($pendingChanges) === 0;
        }

        // if here, then fail with exception
        if (\count($pendingChanges) > 0) {
            // Unit of work was expected to be empty.
            $expected = [];

            // Create a comparision to be able to visually see the pending entities.
            $comparison = new ComparisonFailure(
                $expected,
                $pendingChanges,
                $this->exporter()->export($expected),
                $this->exporter()->export($pendingChanges),
            );

            $this->fail($other, $description, $comparison);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore toString has been overridden by failureDescription
     */
    public function toString(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other): string
    {
        return 'unit of work has no pending changes';
    }
}
