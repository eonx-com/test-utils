<?php
declare(strict_types=1);

namespace Eonx\TestUtils\DataTransferObjects;

class ResponseException
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $subCode;

    /**
     * @var mixed[]|null
     */
    private $violations;

    /**
     * ResponseException constructor.
     * @param string $code
     * @param string $message
     * @param string $subCode
     * @param mixed[]|null $violations
     */
    public function __construct(string $code, string $message, string $subCode, ?array $violations = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->subCode = $subCode;
        $this->violations = $violations;
    }

    /**
     * Get response exception code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Get response exception message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get response exception sub code.
     *
     * @return string
     */
    public function getSubCode(): string
    {
        return $this->subCode;
    }

    /**
     * Get any violations part of response.
     *
     * @return mixed[]|null
     */
    public function getViolations(): ?array
    {
        return $this->violations;
    }
}
