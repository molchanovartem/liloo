<?php

namespace api\schema\type\mutation\salon\service;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class SalonServiceCreateInputType
 *
 * @package api\schema\type\mutation\salon\service
 */
class SalonServiceCreateInputType extends InputObjectType
{
    /**
     * SalonServiceCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'service_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'service_price' => $typeRegistry->nonNull($typeRegistry->decimal()),
                    'service_duration' => $typeRegistry->nonNull($typeRegistry->int())
                ];
            }
        ]);
    }
}