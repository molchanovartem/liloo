<?php

namespace api\graphql\lk\types\mutation\user\schedule;

use api\graphql\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserScheduleUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\user\schedule
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