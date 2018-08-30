<?php

namespace api\schema\type\mutation\master\schedule;

use api\schema\registry\TypeRegistry;

/**
 * Class MasterScheduleCreateInputType
 *
 * @package api\schema\type\mutation\master\schedule
 */
class MasterScheduleCreateInputType extends \GraphQL\Type\Definition\InputObjectType
{
    /**
     * MasterScheduleCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function() use ($typeRegistry) {
                return [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'type' => $typeRegistry->nonNull($typeRegistry->int()),
                    'start_date' => $typeRegistry->nonNull($typeRegistry->dateTime()),
                    'end_date' => $typeRegistry->nonNull($typeRegistry->dateTime())
                ];
            }
        ]);
    }
}