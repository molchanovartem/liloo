<?php

namespace api\graphql\site\types\mutation\appointment;

use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\site\services\AppointmentService;
use api\graphql\core\TypeRegistry;

/**
 * Class AppointmentType
 *
 * @package api\graphql\site\types\mutation\appointment
 */
class AppointmentType implements MutationFieldsTypeInterface
{
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $inputTypeRegistry = $typeRegistry->getMutationRegistry();

        return [
            'appointmentCreate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputTypeRegistry->appointmentCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new AppointmentService())->create($args['attributes']);
                }
            ],
        ];
    }
}