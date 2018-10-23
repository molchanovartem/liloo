<?php

namespace api\graphql\lk\types\mutation\convenience;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class ConvenienceUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\convenience
 */
class ConvenienceUpdateInputType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'name' => $typeRegistry->string(),
                    'description' => $typeRegistry->string()
                ];
            }
        ]);
    }
}