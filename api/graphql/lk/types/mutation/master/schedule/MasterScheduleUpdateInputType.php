<?php

namespace api\graphql\lk\types\mutation\master\schedule;

use api\graphql\TypeRegistry;

/**
 * Class MasterScheduleUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\master\schedule
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