<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use Eonx\TestUtils\Comparators\ScalarComparator;
use Eonx\TestUtils\Helpers\ApplyFuzziness;
use Eonx\TestUtils\Helpers\Interfaces\ApplyFuzzinessInterface;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\IsJson;
use SebastianBergmann\Comparator\Factory;

class JsonSameAsArray extends Constraint
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
     * JsonEqualsArray constructor.
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
        $isJson = new IsJson();
        $isJson->evaluate($other, $description, $returnResult);

        $actualDecoded = \json_decode((string)$other, true, 512, \JSON_THROW_ON_ERROR);

        $fuzzyActual = $this->fuzziness->apply(
            $actualDecoded,
            $this->expected,
            ':fuzzy:'
        );

        // Override IsEqual scalar comparisons to be strong.
        $scalarComparator = new ScalarComparator();
        Factory::getInstance()->register($scalarComparator);

        $isEqual = new IsEqual($this->expected);

        $result = $isEqual->evaluate($fuzzyActual, $description, $returnResult);

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
