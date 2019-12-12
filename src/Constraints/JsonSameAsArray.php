<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use Eonx\TestUtils\Helpers\ApplyFuzziness;
use Eonx\TestUtils\Helpers\Interfaces\ApplyFuzzinessInterface;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsIdentical;
use PHPUnit\Framework\Constraint\IsJson;

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
    public function evaluate($other, string $description = '', bool $returnResult = false)
    {
        $isJson = new IsJson();
        $isJson->evaluate($other, 'String is not a valid JSON.');

        $actualDecoded = \json_decode((string)$other, true, 512, \JSON_THROW_ON_ERROR);

        $fuzzyActual = $this->fuzziness->apply(
            $actualDecoded,
            $this->expected,
            ':fuzzy:'
        );

        $isSame = new IsIdentical($this->expected);
        return $isSame->evaluate($fuzzyActual, $description, $returnResult);
    }
}
