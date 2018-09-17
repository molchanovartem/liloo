<?php

namespace api\schema\type\mutation\salon;


use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class SalonCreateInputType
 *
 * @package api\schema\type\mutation\salon
 */
class SalonCreateInputType extends InputObjectType
{
    /**
     * SalonCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'country_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'city_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'status' => $typeRegistry->nonNull($typeRegistry->int()),
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'address' => $typeRegistry->string(),
                    'specializations_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id())),
                    'conveniences_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ];
            }
        ]);
    }
}