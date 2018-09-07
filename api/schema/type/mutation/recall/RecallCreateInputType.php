<?php

namespace api\schema\type\mutation\recall;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class RecallCreateInputType
 * @package api\schema\type\mutation\recall
 */
class RecallCreateInputType extends InputObjectType
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
                    'appointment_id' => $typeRegistry->id(),
                    'user_id' => $typeRegistry->id(),
                    'assessment' => $typeRegistry->int(),
                    'parent_id' => $typeRegistry->int(),
                    'type' => $typeRegistry->int(),
                    'text' => $typeRegistry->string(),
                ];
            }
        ]);
    }
}
