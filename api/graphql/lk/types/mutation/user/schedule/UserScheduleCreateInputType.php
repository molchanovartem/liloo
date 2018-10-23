<?php

namespace api\graphql\lk\types\mutation\user\schedule;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class UserScheduleCreateInputType
 *
 * @package api\graphql\lk\types\mutation\user\schedule
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