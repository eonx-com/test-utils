<?php
declare(strict_types=1);

namespace Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects;

use LoyaltyCorp\RequestHandlers\Request\RequestObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\Exceptions\RequestValidationExceptionStub;

/**
 * @coversNothing
 */
class TestRequestStub implements RequestObjectInterface
{
    /**
     * @Assert\Type("bool")
     *
     * @var bool
     */
    private $active;

    /**
     * @Assert\Type("Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub")
     *
     * @var \Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub|null
     */
    private $deeper;

    /**
     * @Assert\Type("array")
     *
     * @var \Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub[]|null
     */
    private $evenDeeper;

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
     * @param null|\Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub $deeper
     * @param \Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub[]|null $evenDeeper
     */
    public function __construct(
        bool $active,
        string $name,
        ?TestRequestStub $deeper = null,
        ?array $evenDeeper = null
    ) {
        $this->active = $active;
        $this->deeper = $deeper;
        $this->evenDeeper = $evenDeeper;
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
     * Returns deeper.
     *
     * @return \Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub|null
     */
    public function getDeeper(): ?TestRequestStub
    {
        return $this->deeper;
    }

    /**
     * Returns even deeper.
     *
     * @return \Tests\Eonx\TestUtils\Stubs\Helpers\RequestObjects\TestRequestStub[]
     */
    public function getEvenDeeper(): array
    {
        return $this->evenDeeper ?? [];
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
