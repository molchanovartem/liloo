<?php

namespace api\schema\type\mutation\input;

use GraphQL\Type\Definition\InputObjectType;
use api\schema\TypeRegistry;

/**
 * Class AppointmentItemUpdateType
 *
 * @package api\schema\type\mutation\input
 */
class AppointmentItemUpdateType extends InputObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->nonNull($typeRegistry->int()),
                    'quantity' => $typeRegistry->nonNull($typeRegistry->int())
                ];
            }
        ]);
    }
}