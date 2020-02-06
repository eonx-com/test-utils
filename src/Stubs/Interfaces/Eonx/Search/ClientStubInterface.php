<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Stubs\Interfaces\Eonx\Search;

use LoyaltyCorp\Search\Interfaces\ClientInterface;

interface ClientStubInterface extends ClientInterface
{
    /**
     * Returns all bulk actions.
     *
     * @return \LoyaltyCorp\Search\DataTransferObjects\IndexAction[]
     */
    public function getBulkActions(): array;
}
