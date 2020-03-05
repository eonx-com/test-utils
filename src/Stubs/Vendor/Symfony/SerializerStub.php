<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Vendor\Symfony;

use Eonx\TestUtils\Stubs\BaseStub;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @codeCoverageIgnore
 */
class SerializerStub extends BaseStub implements SerializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function serialize($data, $format, array $context = [])
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize($data, $type, $format, array $context = [])
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
}
