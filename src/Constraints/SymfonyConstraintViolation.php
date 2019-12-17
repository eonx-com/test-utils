<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsIdentical;
use SebastianBergmann\Comparator\ComparisonFailure;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class SymfonyConstraintViolation extends Constraint
{
    /**
     * @var string
     */
    private $expected;

    /**
     * ConstraintViolation constructor.
     *
     * @param string $expected
     */
    public function __construct(string $expected)
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
        if ($other instanceof ConstraintViolationListInterface === false) {
            throw new AssertionFailedError(
                'Supplied list is not a valid constraint violation list.'
            );
        }

        $toString = [$other, '__toString'];

        if (\is_callable($toString) === false) {
            throw new AssertionFailedError('No __toString() method is available on the violation list');
        }

        $identical = new IsIdentical($this->expected);
        $result = $identical->evaluate($toString(), $description, true);

        // if return result is true, return the evaluator result.
        if ($returnResult === true) {
            return $result;
        }

        if ($result === false) {
            // Create comparision to generate a diff.
            $comparision = new ComparisonFailure(
                $this->expected,
                $other,
                \sprintf("'%s'", $this->expected),
                \sprintf("'%s'", $toString())
            );

            $this->fail($other, $description, $comparision);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'expected errors match constraint violations';
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other): string
    {
        // to keep the error output clean,
        // we override failure description to just contain the error string and comparision.
        return $this->toString();
    }
}
