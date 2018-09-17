<?php

namespace api\schema\type\mutation\recall;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class RecallResponseCreateInputType
 * @package api\schema\type\mutation\recall
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
