<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Stubs;

use Eonx\TestUtils\Stubs\BaseStub;

/**
 * @coversNothing
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class BaseStubCustomisableResponseStub extends BaseStub
{
    /**
     * Example method for base stub functionality..
     *
     * @param string $arg
     *
     * @return string|null
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Not unused
     */
    public function example(string $arg): ?string
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars());
    }

    /**
     * Customised response handling.
     *
     * {@inheritdoc}
     *
     * @noinspection PhpMethodNamingConventionInspection
     */
    protected function _getResponseFor(string $method, array $args, $default) // phpcs:ignore
    {
        if ($method === 'example') {
            return $args['arg'];
        }

        return parent::_getResponseFor($method, $args, $default);
    }
}
