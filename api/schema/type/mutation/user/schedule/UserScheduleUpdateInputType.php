<?php

namespace api\schema\type\mutation\user\schedule;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserScheduleUpdateInputType
 *
 * @package api\schema\type\mutation\user\schedule
 */
class UserScheduleUpdateInputType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'type' => $typeRegistry->int(),
                    'start_date' => $typeRegistry->dateTime(),
                    'end_date' => $typeRegistry->dateTime()
                ];
            }
        ]);
    }
}