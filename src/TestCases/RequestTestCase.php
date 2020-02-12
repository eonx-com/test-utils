<?php
declare(strict_types=1);

namespace Eonx\TestUtils\TestCases;

use EoneoPay\Utils\AnnotationReader;
use LoyaltyCorp\RequestHandlers\Exceptions\RequestValidationException;
use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\ConstraintViolationList;
use ReflectionClass;
use ReflectionProperty;

/**
 * @coversNothing
 */
abstract class RequestTestCase extends TestCase
{
    /**
     * Returns the class to be tested.
     *
     * @return string
     *
     * @phpstan-return class-string
     */
    abstract public function getRequestClass(): string;

    /**
     * Tests that the Request has a valid Exception class
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testPropertiesHaveTypeAssertion(): void
    {
        $class = new ReflectionClass(static::getRequestClass());
        $classProperties = $class->getProperties();

        $reader = $this->app->make(AnnotationReader::class);

        $untypedProperties = \array_filter(
            $classProperties,
            static function (ReflectionProperty $property) use ($reader): bool {
                $type = $reader->getPropertyAnnotation($property, Type::class);

                if ($type instanceof Type === false) {
                    return false;
                }

                /**
                 * @var \Symfony\Component\Validator\Constraints\Type $type
                 *
                 * @see https://youtrack.jetbrains.com/issue/WI-37859 - typehint required until PhpStorm recognises ===
                 */

                return \in_array('PreValidate', $type->groups, true) === false;
            }
        );

        $propertyNames = \array_map(static function (ReflectionProperty $property): string {
            return $property->getName();
        }, $untypedProperties);

        static::assertSame([], $propertyNames, 'Properties without types');
    }

    /**
     * Tests that the Request has a valid Exception class.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testRequestExceptionClass(): void
    {
        $class = static::getRequestClass();
        $reflection = new ReflectionClass($class);

        $instance = $reflection->newInstanceWithoutConstructor();

        self::assertInstanceOf(RequestObjectInterface::class, $instance);

        /** @var \LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface $instance */
        $exceptionClass = $instance::getExceptionClass();

        $exception = new $exceptionClass(new ConstraintViolationList());

        self::assertInstanceOf(RequestValidationException::class, $exception);
    }

    /**
     * Builds a failing request, and returns a formatted validation failures array.
     *
     * @param string $jsonIn
     * @param mixed[]|null $context
     *
     * @return mixed[]
     */
    protected function buildFailingRequest(string $jsonIn, ?array $context = null): array
    {
        return $this->createRequestObjectTestHelper()->buildFailingRequest(
            static::getRequestClass(),
            $jsonIn,
            $context
        );
    }

    /**
     * Returns an unvalidated request object. The request object is not valid and may
     * cause fatal errors.
     *
     * @param string $dtoClass
     * @param mixed[] $properties
     *
     * @return \LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface
     */
    protected function buildUnvalidatedRequestObject(
        string $dtoClass,
        array $properties
    ): RequestObjectInterface {
        return $this->createRequestObjectTestHelper()
            ->buildUnvalidatedRequest($dtoClass, '{}', $properties);
    }

    /**
     * Tests object creation is successful.
     *
     * @param string $jsonIn
     * @param mixed[]|null $context
     *
     * @return \LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface
     */
    protected function buildValidatedRequest(
        string $jsonIn,
        ?array $context = null
    ): RequestObjectInterface {
        return $this->buildRequestObject(
            static::getRequestClass(),
            $context ?? [],
            $jsonIn
        );
    }
}
