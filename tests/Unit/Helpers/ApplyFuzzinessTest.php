<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Helpers;

use Eonx\TestUtils\Helpers\ApplyFuzziness;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Eonx\TestUtils\Helpers\ApplyFuzziness
 */
class ApplyFuzzinessTest extends TestCase
{
    /**
     * Test fuzziness is applied to actual array.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testApply(): void
    {
        $actual = [
            'random' => 'value',
            'date' => '2019-10-10T00:00:00Z',
            'deep' => [
                'deeper' => [
                    'key' => 'value',
                    'date' => '2019-10-10T00:00:00+0000',
                ]
            ]
        ];

        $expected = [
            'random' => 'value',
            'date' => ':fuzzy:',
            'deep' => [
                'deeper' => [
                    'key' => 'value',
                    'date' => ':fuzzy:',
                ]
            ]
        ];

        $fuzziness = new ApplyFuzziness();

        $fuzzyActual = $fuzziness->apply(
            $actual,
            $expected,
            ':fuzzy:'
        );

        self::assertSame($expected, $fuzzyActual);
    }
}
