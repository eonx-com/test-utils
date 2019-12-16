<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers;

use Eonx\TestUtils\Helpers\Interfaces\RequestPropertiesParserInterface;
use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;

class RequestPropertiesParser implements RequestPropertiesParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function get(RequestObjectInterface $object): array
    {
        $interfaceMethods = \get_class_methods(RequestObjectInterface::class);
        $instanceMethods = \get_class_methods($object);

        $instanceOnlyMethods = \array_diff($instanceMethods, $interfaceMethods);
        $retrieveMethods = \array_merge(
            $this->getMethodsByPrefix($instanceOnlyMethods, 'get'),
            $this->getMethodsByPrefix($instanceOnlyMethods, 'is')
        );

        $actual = [];
        foreach ($retrieveMethods as $method => $property) {
            $callable = [$object, $method];
            if (\is_callable($callable) === false) {
                // @codeCoverageIgnoreStart
                // Unable to be tested. get_class_methods returns only public methods
                continue;
                // @codeCoverageIgnoreEnd
            }

            $actual[$property] = $callable();
        }

        return $actual;
    }

    /**
     * Get list of methods that have the provided prefix.
     *
     * @param string[] $methods List of methods to look up.
     * @param string $prefix Prefix to look for, eg 'get'.
     *
     * @return string[] Map of method to matching property name. eg; 'getFoo' => 'foo'
     */
    private function getMethodsByPrefix(array $methods, string $prefix): array
    {
        $response = [];
        foreach ($methods as $method) {
            if (\strncmp($method, $prefix, \strlen($prefix)) === 0) {
                $response[$method] = \lcfirst(\substr($method, \strlen($prefix)));
            }
        }

        return $response;
    }
}
