<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers;

use Eonx\TestUtils\Helpers\Interfaces\ApplyFuzzinessInterface;

final class ApplyFuzziness implements ApplyFuzzinessInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(array $actual, array $expected, string $fuzzyValue, ?array $keys = null): array
    {
        foreach ($actual as $key => &$value) {
            /**
             * @var string[] Keys of the current iteration depth (including current key)
             */
            $iterationKeys = $keys ?? [];
            $iterationKeys[] = $key;

            if (\is_array($value) === true) {
                // Recursively call function to apply fuzziness to arrays on any depth
                $value = $this->apply($value, $expected, $fuzzyValue, $iterationKeys);

                continue;
            }

            // Determine the expected value (if present)
            $expectedValue = $expected;

            foreach ($iterationKeys as $keyValue) {
                $expectedValue = $expectedValue[$keyValue] ?? null;
            }

            /**
             * If expected value equals the fuzzy value, set the actual value to the fuzzy value so that
             * comparision result successfully.
             */
            if ($expectedValue === $fuzzyValue) {
                $value = $fuzzyValue;
            }
        }

        return $actual;
    }
}
