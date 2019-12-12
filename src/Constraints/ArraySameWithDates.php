<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use DateTimeInterface;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsIdentical;

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
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag) Designed by base phpunit constraint.
     */
    public function evaluate($other, string $description = '', bool $returnResult = false)
    {
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

        // Check that two arrays are identical.
        $constraint = new IsIdentical($this->expected);
        return $constraint->evaluate($other, $description, $returnResult);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'arrays are same with flat dates';
    }
}
