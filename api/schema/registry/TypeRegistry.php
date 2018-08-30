<?php

namespace api\schema\registry;

use api\schema\type\MutationType;
use api\schema\type\QueryType;
use GraphQL\Type\Definition\Type;
use api\schema\type\scalar\DateTimeType;
use api\schema\type\scalar\DateType;
use api\schema\type\scalar\DecimalType;

/**
 * Class TypeRegistry
 *
 * @package api\schema
 */
class TypeRegistry
{

    private $types = [];
    /**
     * @var EntityTypeRegistry
     */
    private $entityRegistry;
    /**
     * @var MutationInputTypeRegistry
     */
    private $mutationInputRegistry;

    public function __construct()
    {
        $this->entityRegistry = new EntityTypeRegistry($this);
        $this->mutationInputRegistry = new MutationInputTypeRegistry($this);
    }

    /**
     * @return EntityTypeRegistry
     */
    public function getEntityRegistry()
    {
        return $this->entityRegistry;
    }

    public function getMutationInputRegistry()
    {
        return $this->mutationInputRegistry;
    }

    /**
     * @param string $className
     * @return mixed
     */
    public function get(string $className)
    {
        return $this->types[$className] ?? ($this->types[$className] = new $className($this));
    }

    public function query()
    {
        return $this->get(QueryType::class);
    }

    public function mutation()
    {
        return $this->get(MutationType::class);
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