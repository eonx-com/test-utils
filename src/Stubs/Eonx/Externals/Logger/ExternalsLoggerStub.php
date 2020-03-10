<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Eonx\Externals\Logger;

use EoneoPay\Externals\Logger\Interfaces\LoggerInterface;
use Eonx\TestUtils\Stubs\BaseStub;
use Throwable;

/**
 * @codeCoverageIgnore
 */
final class ExternalsLoggerStub extends BaseStub implements LoggerInterface
{
    /**
     * {@inheritdoc}
     */
    public function alert($message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function critical($message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function emergency($message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function exception(Throwable $exception, ?string $level = null, ?array $context = null): void
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, array $context = [])
    {
        $this->doStubCall(__FUNCTION__, \get_defined_vars(), null);
    }
}
