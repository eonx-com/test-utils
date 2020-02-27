<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\TestCases;

use Eonx\TestUtils\Stubs\BaseStub;
use Eonx\TestUtils\TestCases\UnitTestCase;

/**
 * @coversNothing
 */
abstract class StubTestCase extends UnitTestCase
{
    /**
     * Returns an array of  expectations for methods of a stub that are asserted
     * against the stub methods to ensure they are configured properly.
     *
     * @return mixed[]
     */
    abstract public function getMethodExpectations(): iterable;

    /**
     * Data provider for testStubMethods.
     *
     * @return mixed[]
     */
    public function getStubMethodData(): iterable
    {
        yield from $this->getMethodExpectations();
    }

    /**
     * Returns the stub class to be tested.
     *
     * @phpstan-return class-string
     *
     * @return string
     */
    abstract public function getStubClass(): string;

    /**
     * Tests that stub methods are correctly defined.
     *
     * @param string $method
     * @param mixed[] $inputArgs
     * @param mixed $returnValue
     *
     * @return void
     *
     * @dataProvider getStubMethodData
     */
    public function testStubMethods(string $method, array $inputArgs, $returnValue): void
    {
        $stub = $this->createStubForTest($method, $returnValue);

        $result = $stub->$method(...\array_values($inputArgs));

        self::assertEquals($returnValue, $result);
        self::assertEqualsCanonicalizing([$inputArgs], $stub->getCalls($method));
    }

    /**
     * Returns a stub configured a response for a method.
     *
     * @param string $method
     * @param mixed $returnValue
     *
     * @return \Eonx\TestUtils\Stubs\BaseStub
     */
    protected function createStubForTest(string $method, $returnValue): BaseStub
    {
        $class = $this->getStubClass();

        return new $class([
            $method => [
                $returnValue
            ]
        ]);
    }
}
