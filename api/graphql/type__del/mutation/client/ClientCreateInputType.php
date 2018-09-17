<?php

namespace api\schema\type\mutation\client;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class ClientCreateInputType
 *
 * @package api\schema\type\mutation\client
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