<?php

namespace api\schema\type\mutation\salon;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class SalonUpdateInputType
 *
 * @package api\schema\type\mutation\salon
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
                    'specializations_id' => $typeRegistry->listOff($typeRegistry->id()),
                    'conveniences_id' => $typeRegistry->listOff($typeRegistry->id())
                ];
            }
        ]);
    }
}