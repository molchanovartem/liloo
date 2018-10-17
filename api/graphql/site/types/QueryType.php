<?php

namespace api\graphql\site\types;

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
                return array_merge([]);
            }
        ]);
    }
}