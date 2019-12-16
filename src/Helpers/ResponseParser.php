<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Helpers;

use Eonx\TestUtils\DataTransferObjects\ResponseException;
use Eonx\TestUtils\Helpers\Exceptions\NoValidResponseException;
use Eonx\TestUtils\Helpers\Interfaces\ResponseParserInterface;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

class ResponseParser implements ResponseParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parseError(Response $response): ?ResponseException
    {
        $content = (string)$response->getContent();

        // if empty string, return early
        if ($content === '') {
            return null;
        }

        $contentType = $response->headers->get('content-type');

        if ($contentType === 'application/json') {
            return $this->parseFromJson($content);
        }

        if ($contentType === 'application/xml') {
            return $this->parseFromXml($content);
        }

        throw new NoValidResponseException(
            'Response does not contain a valid content-type header.'
        );
    }

    /**
     * Parse json and get response exception.
     *
     * @param string $input
     *
     * @return \Eonx\TestUtils\DataTransferObjects\ResponseException|null
     */
    public function parseFromJson(string $input): ?ResponseException
    {
        try {
            $contents = \json_decode($input, true, 512, \JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new NoValidResponseException(
                \sprintf('Could not extract valid JSON from response: %s. Failed with: %s', $input,
                    $exception->getMessage())
            );
        }

        return $this->prepareResponseException($contents);
    }

    /**
     * In case the content was not JSON, try it as an XML.
     *
     * @param string $input
     *
     * @return \Eonx\TestUtils\DataTransferObjects\ResponseException
     */
    private function parseFromXml(string $input): ?ResponseException
    {
        // suppress warnings so we acn handle ourselves.
        \libxml_use_internal_errors(true);

        $xmlNode = \simplexml_load_string($input);

        if ($xmlNode === false) {
            throw new NoValidResponseException(
                \sprintf('Could not extract valid XML from response: %s', $input)
            );
        }

        $contents = (array)$xmlNode->children();

        return $this->prepareResponseException($contents);
    }

    /**
     * Prepare ResponseException from content.
     *
     * @param mixed[] $contents
     *
     * @return \Eonx\TestUtils\DataTransferObjects\ResponseException|null
     */
    private function prepareResponseException(array $contents): ?ResponseException
    {
        $code = $contents['code'] ?? null;
        $message = $contents['message'] ?? null;
        $subCode = $contents['sub_code'] ?? null;
        $violations = $contents['violations'] ?? null;

        if ($code !== null && $subCode !== null && $message !== null) {
            return new ResponseException(
                (string)$code,
                (string)$message,
                (string)$subCode,
                (array)$violations
            );
        }

        return null;
    }
}
