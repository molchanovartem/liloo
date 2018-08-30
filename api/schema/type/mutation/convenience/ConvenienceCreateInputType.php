<?php

namespace api\schema\type\mutation\convenience;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class ConvenienceCreateInputType
 *
 * @package api\schema\type\mutation\convenience
 */
class ConvenienceCreateInputType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'description' => $typeRegistry->string()
                ];
            }
        ]);
    }
}