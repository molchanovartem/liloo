<?php

namespace api\graphql\lk\types\mutation\salon;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class SalonCreateInputType
 *
 * @package api\graphql\lk\types\mutation\salon
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