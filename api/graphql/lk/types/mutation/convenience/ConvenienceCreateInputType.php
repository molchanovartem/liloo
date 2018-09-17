<?php

namespace api\graphql\lk\types\mutation\convenience;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class ConvenienceCreateInputType
 *
 * @package api\graphql\lk\types\mutation\convenience
 */
class ConvenienceCreateInputType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'description' => $typeRegistry->string(),
                ];
            }
        ]);
    }
}