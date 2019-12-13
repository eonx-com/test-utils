<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers\Interfaces;

use Eonx\TestUtils\DataTransferObjects\ResponseException;
use Symfony\Component\HttpFoundation\Response;

interface ResponseParserInterface
{
    /**
     * Parse response and extract errors.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return \Eonx\TestUtils\DataTransferObjects\ResponseException|null
     */
    public function parseError(Response $response): ?ResponseException;
}
