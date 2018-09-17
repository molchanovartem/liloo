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
                    'appointment_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'assessment' => $typeRegistry->nonNull($typeRegistry->int()),
                    'text' => $typeRegistry->nonNull($typeRegistry->string()),
                ];
            }
        ]);
    }
}
