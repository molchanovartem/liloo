<?php

namespace api\schema\type\mutation\user\schedule;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserScheduleCreateInputType
 *
 * @package api\schema\type\mutation\user\schedule
 */
class UserScheduleCreateInputType extends InputObjectType
{
    /**
     * UserScheduleCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'type' => $typeRegistry->nonNull($typeRegistry->int()),
                    'start_date' => $typeRegistry->nonNull($typeRegistry->dateTime()),
                    'end_date' => $typeRegistry->nonNull($typeRegistry->dateTime())
                ];
            }
        ]);
    }
}