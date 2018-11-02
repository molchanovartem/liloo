<?php

namespace api\graphql\lk\types\mutation\salon;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class SalonUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\salon
 */
class SalonUpdateInputType extends InputObjectType
{
    /**
     * SalonUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'country_id' =>$typeRegistry->id(),
                    'city_id' => $typeRegistry->id(),
                    'status' => $typeRegistry->int(),
                    'name' => $typeRegistry->string(),
                    'address' => $typeRegistry->string(),
                    'phone' => $typeRegistry->string(),
                    'latitude' => $typeRegistry->float(),
                    'longitude' => $typeRegistry->float(),
                    'specializations_id' => $typeRegistry->listOff($typeRegistry->id()),
                    'conveniences_id' => $typeRegistry->listOff($typeRegistry->id())
                ];
            }
        ]);
    }
}