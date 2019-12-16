<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Unit\Helpers;

use Eonx\TestUtils\DataTransferObjects\ResponseException;
use Eonx\TestUtils\Helpers\Exceptions\NoValidResponseException;
use Eonx\TestUtils\Helpers\ResponseParser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \Eonx\TestUtils\Helpers\ResponseParser
 */
class ResponseParserTest extends TestCase
{
    /**
     * Generate cases to test parsing errors from response.
     *
     * @return mixed[]
     */
    public function generateParseErrorCases(): iterable
    {
        yield 'Empty response' => [
            'content' => new Response(''),
            'exception' => null,
            'result' => null,
        ];

        yield 'When no content-type is set' => [
            'content' => new Response('{}'),
            'exception' => new NoValidResponseException(
                'Response does not contain a valid content-type header.'
            ),
            'result' => null
        ];

        yield 'Is not a valid json' => [
            'content' => new Response('{abc}', 200, ['content-type' => 'application/json']),
            'exception' => new NoValidResponseException(
                'Could not extract valid JSON from response: {abc}. Failed with: Syntax error'
            ),
            'result' => null,
        ];

        yield 'Is not a valid xml' => [
            'content' => new Response('<xml>&</xml>', 200, ['content-type' => 'application/xml']),
            'exception' => new NoValidResponseException('Could not extract valid XML from response: <xml>&</xml>'), //phpcs:ignore
            'result' => null,
        ];

        yield 'Parse error from json' => [
            'content' => new Response(
                '{"code": "1", "sub_code": "2", "message": "Exception thrown.", "violations": {"key": "missing"}}',
                //phpcs:ignore
                400,
                ['content-type' => 'application/json']
            ),
            'exception' => null,
            'result' => new ResponseException(
                '1',
                'Exception thrown.',
                '2',
                ['key' => 'missing']
            ),
        ];

        yield 'Parse error from xml' => [
            'content' => new Response(
                '<xml><code>1</code><sub_code>2</sub_code><message>Exception thrown.</message><violations><key>missing</key></violations></xml>', //phpcs:ignore
                400,
                ['content-type' => 'application/xml']
            ),
            'exception' => null,
            'result' => new ResponseException(
                '1',
                'Exception thrown.',
                '2',
                ['key' => 'missing']
            ),
        ];

        yield 'Parse returns null when no exception found' => [
            'content' => new Response('{}', 200, ['content-type' => 'application/json']),
            'exception' => null,
            'result' => null
        ];
    }

    /**
     * Test parsing errors from response object.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Eonx\TestUtils\Helpers\Exceptions\NoValidResponseException|null $exception
     * @param \Eonx\TestUtils\DataTransferObjects\ResponseException|null $result
     *
     * @return void
     *
     * @dataProvider generateParseErrorCases
     */
    public function testParseError(
        Response $response,
        ?NoValidResponseException $exception,
        ?ResponseException $result
    ): void {
        $parser = new ResponseParser();

        if ($exception !== null) {
            $this->expectException(\get_class($exception));
            $this->expectExceptionMessage($exception->getMessage());
        }

        $parsed = $parser->parseError($response);

        self::assertEquals($result, $parsed);
    }
}
