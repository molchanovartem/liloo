<?php

namespace api\graphql\lk\types\mutation\client;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class ClientCreateInputType
 *
 * @package api\graphql\lk\types\mutation\client
 */
class ClientCreateInputType extends InputObjectType
{
    /**
     * ClientCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'country_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'city_id' => $typeRegistry->id(),
                    'status' => $typeRegistry->nonNull($typeRegistry->int()),
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'phone' => $typeRegistry->nonNull($typeRegistry->string()),
                    'address' => $typeRegistry->string(),
                ];
            }
        ]);
    }
}