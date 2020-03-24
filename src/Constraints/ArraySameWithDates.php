<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use DateTimeInterface;
use Eonx\TestUtils\Comparators\ScalarComparator;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\IsIdentical;
use SebastianBergmann\Comparator\Factory;

class ArraySameWithDates extends Constraint
{
    /**
     * @var mixed[]
     */
    private $expected;

    /**
     * ArraySameWithDates constructor.
     *
     * @param mixed[] $expected
     */
    public function __construct(array $expected)
    {
        $this->expected = $expected;
    }

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
        if (\is_array($other) === false) {
            $this->fail($other, $description);
        }

        // If array can be compared without invoking constraint,
        // that's the best path.
        if ($this->expected === $other) {
            return true;
        }

        $format = static function (&$value): void {
            if (($value instanceof DateTimeInterface) === true) {
                /**
                 * @var \DateTimeInterface $value
                 *
                 * @see https://youtrack.jetbrains.com/issue/WI-37859 - typehint required until PhpStorm recognises ===
                 */
                $value = $value->format(DateTimeInterface::RFC3339);
            }
        };

        \array_walk_recursive($this->expected, $format);
        \array_walk_recursive($other, $format);

        // Override IsEqual scalar comparisons to be strong.
        $scalarComparator = new ScalarComparator();
        Factory::getInstance()->register($scalarComparator);

        $isEqual = new IsEqual($this->expected);

        $result = $isEqual->evaluate($other, $description, $returnResult);

        Factory::getInstance()->unregister($scalarComparator);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return \sprintf(
            'is same as %s',
            $this->exporter()->export($this->expected)
        );
    }
}
