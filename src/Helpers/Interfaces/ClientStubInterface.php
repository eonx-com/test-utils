<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers\Interfaces;

use LoyaltyCorp\Search\Interfaces\ClientInterface;

interface ClientStubInterface extends ClientInterface
{
    /**
     * Spy on created aliases
     *
     * @return mixed[]
     */
    public function getCreatedAliases(): array;

    /**
     * Spy on created indices
     *
     * @return mixed[]
     */
    public function getCreatedIndices(): array;

    /**
     * Spy on deleted aliases
     *
     * @return string[]
     */
    public function getDeletedAliases(): array;

    /**
     * Spy on deleted indices
     *
     * @return string[]
     */
    public function getDeletedIndices(): array;

    /**
     * Spy on alias that had its index swapped
     *
     * @return string[] Alias => Index
     */
    public function getSwappedAliases(): array;

    /**
     * Get list if indices updated.
     *
     * @return mixed[]
     */
    public function getUpdatedIndices(): array;

    /**
     * Reset spied data.
     *
     * @return void
     */
    public function reset(): void;
}
