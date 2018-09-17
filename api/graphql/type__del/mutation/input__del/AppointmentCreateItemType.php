<?php

namespace api\schema\type\mutation\input;

use api\schema\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class AppointmentCreateItemType
 *
 * @package api\schema\type\mutation\input
 */
class AppointmentCreateItemType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'service_id' => $typeRegistry->nonNull($typeRegistry->int()),
                    'quantity' => $typeRegistry->nonNull($typeRegistry->int())
                ];
            }
        ]);
    }
}