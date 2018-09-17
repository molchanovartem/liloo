<?php

namespace api\schema\type\mutation\appointment;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class AppointmentUpdateInputType
 *
 * @package api\schema\type\mutation\appointment
 */
class AppointmentUpdateInputType extends InputObjectType
{
    /**
     * AppointmentUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry, $inputRegistry) {
                return [
                    'user_id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'client_id' => $typeRegistry->id(),
                    'status' => $typeRegistry->int(),
                    'start_date' => $typeRegistry->dateTime(),
                    'end_date' => $typeRegistry->dateTime(),
                    'items' => $typeRegistry->listOff($inputRegistry->appointmentItemCreate())
                ];
            }
        ]);
    }
}