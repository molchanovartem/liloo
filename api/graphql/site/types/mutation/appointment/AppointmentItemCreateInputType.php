<?php

namespace api\graphql\site\types\mutation\appointment;

use api\graphql\core\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class AppointmentItemCreateInputType
 *
 * @package api\graphql\site\types\mutation\appointment
 */
class AppointmentItemCreateInputType extends InputObjectType
{
    /**
     * AppointmentItemCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'service_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'quantity' => $typeRegistry->nonNull($typeRegistry->int())
                ];
            }
        ]);
    }
}