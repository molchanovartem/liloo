<?php

namespace api\graphql\lk\types\mutation\salon\service;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class SalonServiceUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\salon\service
 */
class SalonServiceUpdateInputType extends InputObjectType
{
    /**
     * SalonServiceUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'service_price' => $typeRegistry->decimal(),
                    'service_duration' =>$typeRegistry->int()
                ];
            }
        ]);
    }
}