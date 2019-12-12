<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers\Interfaces;

/**
 * A helper class to apply fuzziness to an actual array based on
 * the fuzziness of expected array.
 */
interface ApplyFuzzinessInterface
{
    /**
     * Apply fuzziness from expected array to actual array.
     *
     * @param mixed[] $actual
     * @param mixed[] $expected
     * @param string $fuzzyValue
     * @param mixed[]|null $keys
     *
     * @return mixed[] Returns the actual array with fuzziness applied.
     */
    public function apply(array $actual, array $expected, string $fuzzyValue, ?array $keys = null): array;
}
