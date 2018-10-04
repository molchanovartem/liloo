<?php

namespace api\graphql;

use GraphQL\Type\Definition\ObjectType;

/**
 * Class EntityType
 *
 * @package api\graphql
 */
abstract class EntityType extends ObjectType
{
    /**
     * @var TypeRegistry
     */
    protected $typeRegistry;

    protected $entityRegistry;

    /**
     * EntityType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $this->typeRegistry = $typeRegistry;
        $this->entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct([
            'fields' => function () {
                return $this->fields();
            }
        ]);
    }

    /**
     * @return array
     */
    abstract public function fields(): array;
}