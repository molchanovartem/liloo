<?php

namespace api\schema\type\mutation\client;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class ClientUpdateInputType
 *
 * @package api\schema\type\mutation\client
 */
class ClientUpdateInputType extends InputObjectType
{
    /**
     * ClientUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'country_id' => $typeRegistry->id(),
                    'city_id' => $typeRegistry->id(),
                    'status' => $typeRegistry->int(),
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'phone' => $typeRegistry->string(),
                    'address' => $typeRegistry->string(),
                ];
            }
        ]);
    }
}