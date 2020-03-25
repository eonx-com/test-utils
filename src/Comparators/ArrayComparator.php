<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Comparators;

use SebastianBergmann\Comparator\ArrayComparator as BaseArrayComparator;
use SebastianBergmann\Exporter\Exporter;

/**
 * Overridden so that when arrays are compared their values are not shortened.
 */
class ArrayComparator extends BaseArrayComparator
{
    /**
     * ArrayComparator constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->exporter = new class extends Exporter
        {
            /**
             * Overridden so that arrays are not shortened.
             *
             * @noinspection PhpMissingParentCallCommonInspection
             * @noinspection MultipleReturnStatementsInspection
             *
             * @param mixed $value
             *
             * @return string
             */
            public function shortenedExport($value) // phpcs:ignore
            {
                if (\is_string($value)) {
                    return \str_replace("\n", '', $this->export($value));
                }

                return parent::shortenedExport($value);
            }
        };
    }
}
