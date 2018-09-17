<?php

namespace api\graphql;

use GraphQL\Type\Definition\Type;
use api\graphql\types\scalar\DateTimeType;
use api\graphql\types\scalar\DateType;
use api\graphql\types\scalar\DecimalType;

/**
 * Class TypeRegistry
 *
 * @package api\graphql
 */
class TypeRegistry
{
    /**
     * @var array
     */
    private $types = [];
    /**
     * @var AdditionalTypeRegistry
     */
    private $entityRegistry;
    /**
     * @var AdditionalTypeRegistry
     */
    private $mutationInputRegistry;
    /**
     * @var string
     */
    private $queryTypeClass;
    /**
     * @var string
     */
    private $mutationTypeClass;

    /**
     * TypeRegistry constructor.
     *
     * @param $entityTypeRegistryClass
     * @param $mutationInputTypeRegistryClass
     * @param $queryTypeClass
     * @param $mutationTypeClass
     */
    public function __construct(
        $entityTypeRegistryClass,
         $mutationInputTypeRegistryClass,
        $queryTypeClass,
        $mutationTypeClass
    )
    {
        $this->entityRegistry = new $entityTypeRegistryClass($this);
        $this->mutationInputRegistry = new $mutationInputTypeRegistryClass($this);
        $this->queryTypeClass = $queryTypeClass;
        $this->mutationTypeClass = $mutationTypeClass;
    }

    /**
     * @return AdditionalTypeRegistry
     */
    public function getEntityRegistry()
    {
        return $this->entityRegistry;
    }

    /**
     * @return AdditionalTypeRegistry
     */
    public function getMutationInputRegistry()
    {
        return $this->mutationInputRegistry;
    }

    /**
     * @return mixed
     */
    public function query()
    {
        return $this->get($this->queryTypeClass);
    }

    /**
     * @return mixed
     */
    public function mutation()
    {
        return $this->get($this->mutationTypeClass);
    }

    /**
     * @param string $className
     * @return mixed
     */
    public function get(string $className)
    {
        return $this->types[$className] ?? ($this->types[$className] = new $className($this));
    }

    public function listOff($wrappedType)
    {
        return Type::listOf($wrappedType);
    }

    public function string()
    {
        return Type::string();
    }

    public function int()
    {
        return Type::int();
    }

    public function id()
    {
        return Type::id();
    }

    public function nonNull($wrappedType)
    {
        return Type::nonNull($wrappedType);
    }

    public function date()
    {
        return $this->get(DateType::class);
    }

    public function dateTime()
    {
        return $this->get(DateTimeType::class);
    }

    public function decimal()
    {
        return $this->get(DecimalType::class);
    }

    public function boolean()
    {
        return Type::boolean();
    }

    public function float()
    {
        return Type::float();
    }
}