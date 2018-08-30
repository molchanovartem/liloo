<?php

namespace api\schema\type\mutation\input;

use api\schema\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class AppointmentItemCreateType
 *
 * @package api\schema\type\mutation\input
 */
class AppointmentItemCreateType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'appointment_id' => $typeRegistry->nonNull($typeRegistry->int()),
                    'service_id' => $typeRegistry->nonNull($typeRegistry->int()),
                    'quantity' => $typeRegistry->nonNull($typeRegistry->int())
                ];
            }
        ]);
    }
}