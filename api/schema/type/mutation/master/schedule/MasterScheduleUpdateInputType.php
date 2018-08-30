<?php

namespace api\schema\type\mutation\master\schedule;

use api\schema\registry\TypeRegistry;

/**
 * Class MasterScheduleUpdateInputType
 *
 * @package api\schema\type\mutation\master\schedule
 */
class MasterScheduleUpdateInputType extends \GraphQL\Type\Definition\InputObjectType
{
    /**
     * MasterScheduleUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'start_date' => $typeRegistry->dateTime(),
                    'end_date' => $typeRegistry->dateTime()
                ];
            }
        ]);
    }
}