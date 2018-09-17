<?php

namespace api\graphql\lk\types\mutation\recall;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class RecallResponseCreateInputType
 *
 * @package api\graphql\lk\types\mutation\recall
 */
class RecallResponseCreateInputType extends InputObjectType
{
    /**
     * RecallCreateInputType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'parent_id' => $typeRegistry->nonNull($typeRegistry->int()),
                    'text' => $typeRegistry->nonNull($typeRegistry->string()),
                ];
            }
        ]);
    }
}
