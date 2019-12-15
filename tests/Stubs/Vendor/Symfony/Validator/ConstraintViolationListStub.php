<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Vendor\Symfony\Validator;

use IteratorAggregate;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @coversNothing
 */
class ConstraintViolationListStub implements IteratorAggregate, ConstraintViolationListInterface
{
    /**
     * {@inheritdoc}
     */
    public function add(ConstraintViolationInterface $violation)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function addAll(ConstraintViolationListInterface $otherList)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function get($offset)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function has($offset)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function remove($offset)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function set($offset, ConstraintViolationInterface $violation)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
    }
}
