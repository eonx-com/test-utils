<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use Eonx\TestUtils\Helpers\ApplyFuzziness;
use Eonx\TestUtils\Helpers\Interfaces\ApplyFuzzinessInterface;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsIdentical;

class ArraySame extends Constraint
{
    /**
     * @var mixed[]
     */
    private $expected;

    /**
     * @var \Eonx\TestUtils\Helpers\Interfaces\ApplyFuzzinessInterface
     */
    private $fuzziness;

    /**
     * ArraySame constructor.
     *
     * @param mixed[] $expected
     * @param \Eonx\TestUtils\Helpers\Interfaces\ApplyFuzzinessInterface|null $fuzziness
     */
    public function __construct(array $expected, ?ApplyFuzzinessInterface $fuzziness = null)
    {
        $this->expected = $expected;
        $this->fuzziness = $fuzziness ?? new ApplyFuzziness();
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate($other, string $description = '', bool $returnResult = false)
    {
        if (\is_array($other) === false) {
            $this->fail($other, $description);
        }

        // If array can be compared without invoking constraint,
        // that's the best path.
        if ($this->expected === $other) {
            return true;
        }

        $fuzzyActual = $this->fuzziness->apply(
            $other,
            $this->expected,
            ':fuzzy:'
        );

        $isSame = new IsIdentical($this->expected);

        return $isSame->evaluate($fuzzyActual, $description, $returnResult);
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

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other): string
    {
        return \sprintf('%s is an array', \gettype($other));
    }
}
