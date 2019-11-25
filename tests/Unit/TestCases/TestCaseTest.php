<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\TestCases;

use Eonx\TestUtils\TestCases\TestCase;

/**
 * @covers \Eonx\TestUtils\TestCases\TestCase
 */
class TestCaseTest extends TestCase
{
    /**
     * Tests that getProjectPath works as expected when _
     * @return void
     */
    public function testGetProjectPath(): void
    {
        $path = $this->getProjectPath();

        var_dump($path);
    }
}
