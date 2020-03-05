<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers;

use Eonx\TestUtils\Helpers\Interfaces\RequestPropertiesParserInterface;
use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;
use ReflectionClass;
use ReflectionMethod;

class RequestPropertiesParser implements RequestPropertiesParserInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \ReflectionException
     */
    public function get(RequestObjectInterface $object): array
    {
        $reflClass = new ReflectionClass($object);

        $actual = [];

        foreach ($reflClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            // Static methods are not used for request property comparisons and
            // if the method is defined on RequestObjectInterface it isnt called
            // either.
            if ($method->isStatic() === true ||
                $method->getDeclaringClass()->getName() === RequestObjectInterface::class) {
                continue;
            }

            if (\preg_match('/(is|get)(.*)/', $method->getName(), $matches) !== 1 ||
                ($matches[2] ?? null) === null) {
                continue;
            }

            $property = \lcfirst($matches[2]);

            $value = $method->invoke($object);

            // If we got another request object, convert it into an array as well.
            if ($value instanceof RequestObjectInterface === true) {
                $value = $this->get($value);
            }

            // If we got an array, try find any request objects in there too.
            if (\is_array($value) === true) {
                $value = \array_map(function ($value) {
                    if ($value instanceof RequestObjectInterface === true) {
                        return $this->get($value);
                    }

                    return $value;
                }, $value);
            }

            $actual[$property] = $value;
        }

        return $actual;
    }
}
