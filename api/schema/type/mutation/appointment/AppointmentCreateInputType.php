<?php

namespace api\schema\type\mutation\appointment;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class AppointmentCreateInputType
 *
 * @package api\schema\type\mutation\appointment
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
        $entityRegistry = $typeRegistry->getEntityRegistry();
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry, $inputRegistry) {
                return [
                    'user_id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'client_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'status' => $typeRegistry->nonNull($typeRegistry->int()),
                    'start_date' => $typeRegistry->nonNull($typeRegistry->dateTime()),
                    'end_date' => $typeRegistry->nonNull($typeRegistry->dateTime()),
                    'items' => $typeRegistry->listOff($inputRegistry->appointmentItemCreate())
                ];
            }
        ]);
    }
}