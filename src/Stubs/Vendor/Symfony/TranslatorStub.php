<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Vendor\Symfony;

use Eonx\TestUtils\Stubs\BaseStub;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @coversNothing
 */
class TranslatorStub extends BaseStub implements TranslatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null)
    {
        return $this->doStubCall(__FUNCTION__, \get_defined_vars(), $id);
    }
}
