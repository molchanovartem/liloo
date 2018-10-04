<?php

namespace api\graphql\lk\types\mutation\appointment;

use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;
use api\services\lk\AppointmentService;

/**
 * Class AppointmentType
 *
 * @package api\graphql\lk\types\mutation\appointment
 */
class AppointmentType implements MutationFieldsTypeInterface
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
            'appointmentCreate' => [
                'type' => $entityRegistry->appointment(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->appointmentCreate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new AppointmentService())->create($args['attributes']);
                }
            ],
            'appointmentUpdate' => [
                'type' => $entityRegistry->appointment(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputRegistry->appointmentUpdate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new AppointmentService())->update($args['id'], $args['attributes']);
                }
            ],
            'appointmentDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new AppointmentService())->delete($args['id']);
                }
            ],
        ];
    }

}