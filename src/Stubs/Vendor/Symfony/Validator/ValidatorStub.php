<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Vendor\Symfony\Validator;

use Eonx\TestUtils\Stubs\BaseStub;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @codeCoverageIgnore
 */
class ValidatorStub extends BaseStub implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getMetadataFor($value)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function hasMetadataFor($value)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), false);
    }

    /**
     * {@inheritdoc}
     */
    public function inContext(ExecutionContextInterface $context)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function startContext()
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, $constraints = null, $groups = null)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new ConstraintViolationList());
    }

    /**
     * {@inheritdoc}
     */
    public function validateProperty($object, $propertyName, $groups = null)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new ConstraintViolationList());
    }

    /**
     * {@inheritdoc}
     */
    public function validatePropertyValue($objectOrClass, $propertyName, $value, $groups = null)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), new ConstraintViolationList());
    }
}
