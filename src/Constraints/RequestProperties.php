<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use Eonx\TestUtils\Helpers\Interfaces\RequestPropertiesParserInterface;
use Eonx\TestUtils\Helpers\RequestPropertiesParser;
use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;
use PHPUnit\Framework\Constraint\Constraint;
use SebastianBergmann\Comparator\ComparisonFailure;

class RequestProperties extends Constraint
{
    /**
     * @var mixed[]
     */
    private $expected;

    /**
     * @var \Eonx\TestUtils\Helpers\Interfaces\RequestPropertiesParserInterface
     */
    private $requestParser;

    /**
     * RequestProperties constructor.
     *
     * @param mixed[] $expected
     * @param \Eonx\TestUtils\Helpers\Interfaces\RequestPropertiesParserInterface|null $requestParser
     */
    public function __construct(
        array $expected,
        ?RequestPropertiesParserInterface $requestParser = null
    ) {
        $this->expected = $expected;
        $this->requestParser = $requestParser ?? new RequestPropertiesParser();
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
        if ($other instanceof RequestObjectInterface === false) {
            $this->fail($other, $description);
        }

        /**
         * @var \LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface $other
         *
         * @see https://youtrack.jetbrains.com/issue/WI-37859 - typehint required until PhpStorm recognises === check
         */
        $actual = $this->requestParser->get($other);

        $constraint = new ArraySameWithDates($this->expected);
        $isSame = $constraint->evaluate($actual, $description, true);

        if ($returnResult === true) {
            return $isSame === true;
        }

        if ($isSame === false) {
            // Create a comparision to be able to visually expected vs actual.
            $comparison = new ComparisonFailure(
                $this->expected,
                $actual,
                $this->exporter()->export($this->expected),
                $this->exporter()->export($actual),
            );

            $this->fail($other, $description, $comparison);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore Intentionally overridden by failureDescription, because that provided a clean message output.
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
        if ($other instanceof RequestObjectInterface === false) {
            return 'supplied object is a valid request object';
        }

        return 'request object matches expected array';
    }
}
