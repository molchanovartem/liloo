<?php

namespace api\graphql\site\types\mutation\appointment;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class AppointmentCreateInputType
 *
 * @package api\graphql\site\types\mutation\appointment
 */
class AppointmentCreateInputType extends InputObjectType
{
    /**
     * AppointmentCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $inputTypeRegistry = $typeRegistry->getMutationRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $inputTypeRegistry) {
                return [
                    'user_id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'client_id' => $typeRegistry->id(),
                    'client_name' => $typeRegistry->string(),
                    'client_phone' => $typeRegistry->string(),
                    'start_date' => $typeRegistry->nonNull($typeRegistry->dateTime()),
                    'end_date' => $typeRegistry->nonNull($typeRegistry->dateTime()),
                    'items' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->listOff($inputTypeRegistry->appointmentItemCreate()))
                    ],
                ];
            }
        ]);
    }
}