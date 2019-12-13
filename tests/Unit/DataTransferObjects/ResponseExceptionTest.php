<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\DataTransferObjects;

use Eonx\TestUtils\DataTransferObjects\ResponseException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Eonx\TestUtils\DataTransferObjects\ResponseException
 */
class ResponseExceptionTest extends TestCase
{
    /**
     * Test dto constructor and getters.
     *
     * @return void
     */
    public function testConstructorAndGetters(): void
    {
        $exception = new ResponseException(
            '1010',
            'Exception message',
            '1',
            ['key' => 'missing']
        );

        self::assertSame('1010', $exception->getCode());
        self::assertSame('1', $exception->getSubCode());
        self::assertSame('Exception message', $exception->getMessage());
        self::assertSame(['key' => 'missing'], $exception->getViolations());
    }
}
