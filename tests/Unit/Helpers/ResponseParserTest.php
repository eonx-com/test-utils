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
        yield 'Is not a valid json' => [
            'content' => '{abc}',
            'exception' => new NoValidResponseException('Could not extract valid JSON or XML from response: {abc}'),
            'result' => null,
        ];

        yield 'Is not a valid xml' => [
            'content' => '<xml>&</xml>',
            'exception' => new NoValidResponseException('Could not extract valid JSON or XML from response: <xml>&</xml>'),
            'result' => null,
        ];

        yield 'Parse error from json' => [
            'content' => '{"code": "1", "sub_code": "2", "message": "Exception thrown.", "violations": {"key": "missing"}}',
            'exception' => null,
            'result' => new ResponseException(
                '1',
                'Exception thrown.',
                '2',
                ['key' => 'missing']
            ),
        ];

        yield 'Parse error from xml' => [
            'content' => '<xml><code>1</code><sub_code>2</sub_code><message>Exception thrown.</message><violations><key>missing</key></violations></xml>',
            'exception' => null,
            'result' => new ResponseException(
                '1',
                'Exception thrown.',
                '2',
                ['key' => 'missing']
            ),
        ];

        yield 'Parse returns null when no exception found' => [
            'content' => '{}',
            'exception' => null,
            'result' => null
        ];
    }

    /**
     * Test parsing errors from response object.
     *
     * @param string $content
     * @param \Eonx\TestUtils\Helpers\Exceptions\NoValidResponseException|null $exception
     * @param \Eonx\TestUtils\DataTransferObjects\ResponseException|null $result
     *
     * @return void
     *
     * @dataProvider generateParseErrorCases
     */
    public function testParseError(
        string $content,
        ?NoValidResponseException $exception,
        ?ResponseException $result
    ): void {
        $response = new Response($content);

        $parser = new ResponseParser();

        if ($exception !== null) {
            $this->expectException(\get_class($exception));
            $this->expectExceptionMessage($exception->getMessage());
        }

        $parsed = $parser->parseError($response);

        self::assertEquals($result, $parsed);
    }
}
