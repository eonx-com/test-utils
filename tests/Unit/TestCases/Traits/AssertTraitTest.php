<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases\Traits;

use Eonx\TestUtils\TestCases\Exceptions\InvalidParentClassException;
use Eonx\TestUtils\TestCases\Traits\AssertTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Eonx\TestUtils\TestCases\UnitTestCase
 */
class AssertTraitTest extends TestCase
{
    /**
     * AssertTrait must be used by a class extending TestCase.
     *
     * @return void
     */
    public function testExceptionIsThrownWhenAssertTraitIsNotUsedByCorrectClass(): void
    {
        $this->expectException(InvalidParentClassException::class);
        $this->expectExceptionMessage('AssertTrait must be used by an Eonx\TestUtils\TestCases\TestCase class.');

        new class() {
            use AssertTrait;
        };
    }
}
