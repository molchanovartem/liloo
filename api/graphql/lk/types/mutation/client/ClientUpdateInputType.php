<?php

namespace api\graphql\lk\types\mutation\client;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class ClientUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\client
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