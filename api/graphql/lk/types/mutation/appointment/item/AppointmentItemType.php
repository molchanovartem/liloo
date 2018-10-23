<?php

namespace api\graphql\lk\types\mutation\appointment\item;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\AppointmentService;

/**
 * Class AppointmentItemType
 *
 * @package api\graphql\lk\types\mutation\appointment\item
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
        $inputRegistry = $typeRegistry->getMutationRegistry();

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