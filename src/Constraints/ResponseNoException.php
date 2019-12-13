<?php
declare(strict_types=1);

namespace Eonx\TestUtils\Constraints;

use Eonx\TestUtils\DataTransferObjects\ResponseException;
use Eonx\TestUtils\Helpers\Exceptions\NoValidResponseException;
use Eonx\TestUtils\Helpers\Interfaces\ResponseParserInterface;
use Eonx\TestUtils\Helpers\ResponseParser;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use Symfony\Component\HttpFoundation\Response;

class ResponseNoException extends Constraint
{
    /**
     * @var \Eonx\TestUtils\Helpers\Interfaces\ResponseParserInterface
     */
    private $responseError;

    /**
     * ResponseNoException constructor.
     *
     * @param \Eonx\TestUtils\Helpers\Interfaces\ResponseParserInterface|null $responseError
     */
    public function __construct(?ResponseParserInterface $responseError = null)
    {
        $this->responseError = $responseError ?? new ResponseParser();
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag) Designed by base phpunit constraint.
     */
    public function evaluate($other, string $description = '', bool $returnResult = false)
    {
        // Check for supplied object to be a valid instance of Response.
        $instanceConstraint = new IsInstanceOf(Response::class);
        $isValidInstance = $instanceConstraint->evaluate($other, $description, $returnResult);

        if ($isValidInstance === false && $returnResult === true) {
            return false;
        }

        try {
            /**
             * Trying to parse response error might fail if the response did
             * not contain a valid json or xml response string.
             */
            $responseException = $this->responseError->parseError($other);

            // if response exception was created, and return result is true, return false.
            if ($returnResult === true && $responseException instanceof ResponseException === true) {
                return false;
            }

            if ($responseException instanceof ResponseException === true) {
                $violationsString = '';

                if ($responseException->getViolations() !== null) {
                    $violationsString = "\n\nAnd Violations: " . \print_r($responseException->getViolations(), true);
                }

                $description = \sprintf(
                    'Failed with error code (%s), sub code (%s) and error: %s%s',
                    $responseException->getCode(),
                    $responseException->getSubCode(),
                    $responseException->getMessage(),
                    $violationsString
                );

                $this->fail($other, $description);
            }
        } catch (NoValidResponseException $exception) {
            if ($returnResult === true) {
                return false;
            }

            $this->fail($other, $exception->getMessage());
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'has no exceptions.';
    }
}
