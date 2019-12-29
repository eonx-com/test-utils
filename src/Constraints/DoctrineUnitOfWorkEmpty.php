<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Constraint\Constraint;
use SebastianBergmann\Comparator\ComparisonFailure;

class DoctrineUnitOfWorkEmpty extends Constraint
{
    /**
     * Evaluates the constraint.
     *
     * @param mixed $other
     * @param string $description
     * @param bool $returnResult
     *
     * @return bool|null
     *
     * @noinspection PhpMissingParentCallCommonInspection
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag) Designed by base phpunit constraint.
     */
    public function evaluate($other, string $description = '', bool $returnResult = false): ?bool
    {
        $unitOfWork = $other;
        if ($other instanceof EntityManagerInterface === true) {
            /**
             * @var \Doctrine\ORM\EntityManagerInterface $other
             */
            $unitOfWork = $other->getUnitOfWork();
        }

        if ($unitOfWork instanceof UnitOfWork === false) {
            throw new AssertionFailedError(
                'Supplied object is not a valid UnitOfWork instance.'
            );
        }

        /**
         * @var \Doctrine\ORM\UnitOfWork $unitOfWork
         *
         * @see https://youtrack.jetbrains.com/issue/WI-37859 - typehint required until PhpStorm recognises === check
         */
        $pendingChanges = [
            'scheduled collection deletions' => $unitOfWork->getScheduledCollectionDeletions(),
            'scheduled collection updates' => $unitOfWork->getScheduledCollectionUpdates(),
            'scheduled entity deletions' => $unitOfWork->getScheduledEntityDeletions(),
            'scheduled entity insertions' => $unitOfWork->getScheduledEntityInsertions(),
            'scheduled entity updates' => $unitOfWork->getScheduledEntityUpdates()
        ];

        // Loop through the different scheduled types from unit of work so more context can be provided within failure
        foreach ($pendingChanges as $work => $entities) {
            // No entities is good, unit of work has nothing left to do
            if ($entities === []) {
                unset($pendingChanges[$work]);
                continue;
            }

            $pendingChanges[$work] = \array_map('\get_class', $entities);
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

            $this->fail($unitOfWork, $description, $comparison);
        }

        return true;
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
