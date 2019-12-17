<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers\Interfaces;

use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;

/**
 * Helper class for Request handler objects
 * to convert them to an array representation.
 */
interface RequestPropertiesParserInterface
{
    /**
     * Returns an array of properties and their values when those properties have getters.
     *
     * @param \LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface $object
     *
     * @return mixed[]
     */
    public function get(RequestObjectInterface $object): array;
}
