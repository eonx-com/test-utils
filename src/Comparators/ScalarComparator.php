<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Comparators;

use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\ScalarComparator as BaseScalarComparator;

/**
 * A custom scalar comparator that allows assertEquals on an array to then do assertSame
 * comparisons on scalar values.
 */
class ScalarComparator extends BaseScalarComparator
{
    /**
     * {@inheritdoc}
     */
    public function assertEquals($expected, $actual, $delta = null, $canonicalize = null, $ignoreCase = null): void
    {
        if ($expected !== $actual) {
            throw new ComparisonFailure(
                $expected,
                $actual,
                // no diff is required
                '',
                '',
                false,
                \sprintf(
                    'Failed asserting that %s matches expected %s.',
                    $this->exporter->export($actual),
                    $this->exporter->export($expected)
                )
            );
        }
    }
}
