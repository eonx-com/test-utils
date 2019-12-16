<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\Exceptions;

use LoyaltyCorp\RequestHandlers\Exceptions\RequestValidationException;

/**
 * @coversNothing
 */
class RequestValidationExceptionStub extends RequestValidationException
{
    /**
     * {@inheritdoc}
     */
    public function getErrorCode(): int
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorSubCode(): int
    {
        return 1;
    }
}
