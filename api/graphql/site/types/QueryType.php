<?php

namespace api\graphql\site\types;

use api\graphql\site\types\entity\FreeTimeType;
use api\graphql\site\types\entity\ServiceType;
use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;

/**
 * Class QueryType
 *
 * @package api\graphql\common\types
 */
class QueryType extends ObjectType
{
    /**
     * QueryType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return array_merge(
                    ServiceType::getFieldsQueryType($typeRegistry),
                    FreeTimeType::getFieldsQueryType($typeRegistry)
                );
            }
        ]);
    }
}