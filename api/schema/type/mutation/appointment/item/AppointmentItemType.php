<?php

namespace api\schema\type\mutation\appointment\item;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\AppointmentService;

/**
 * Class AppointmentItemType
 *
 * @package api\schema\type\mutation\appointment\item
 */
class AppointmentItemType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        return [
            'appointmentItemsCreate' => [
                'type' => $typeRegistry->listOff($entityRegistry->appointmentItem()),
                'args' => [
                    'appointment_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($inputRegistry->appointmentItemCreate())),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new AppointmentService())->createItems($args['appointment_id'], $args['items']);
                }
            ],
            'appointmentItemsUpdate' => [
                'type' => $typeRegistry->listOff($entityRegistry->appointmentItem()),
                'args' => [
                    'appointment_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($inputRegistry->appointmentItemCreate())),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new AppointmentService())->createItems($args['appointment_id'], $args['items']);
                }
            ],
            'appointmentItemsDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'appointment_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->int()))
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new AppointmentService())->deleteItems($args['appointmentId'], $args['items']);
                }
            ],
        ];
    }

}