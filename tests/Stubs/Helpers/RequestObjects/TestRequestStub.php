<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects;

use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\Exceptions\RequestValidationExceptionStub;

class TestRequestStub implements RequestObjectInterface
{
    /**
     * @Assert\Type("bool")
     *
     * @var bool
     */
    private $active;

    /**
     * @Assert\Type("string")
     *
     * @var string
     */
    private $name;

    /**
     * Constructor
     *
     * @param bool $active
     * @param string $name
     */
    public function __construct(bool $active, string $name)
    {
        $this->active = $active;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public static function getExceptionClass(): string
    {
        return RequestValidationExceptionStub::class;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns if active or not.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveValidationGroups(): array
    {
        return [];
    }
}
