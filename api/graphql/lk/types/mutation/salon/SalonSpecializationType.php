<?php

namespace api\graphql\lk\types\mutation\salon;

use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;
use api\services\SalonService;

/**
 * Class SalonSpecializationType
 *
 * @package api\graphql\lk\types\mutation\salon
 */
class SalonSpecializationType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        return [
            'salonSpecializationsUpdate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'specializations_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new SalonService())->updateSpecializations($args['salon_id'], $args['specializations_id']);
                }
            ],
            'salonSpecializationsDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'specializations_id' => $typeRegistry->listOff($typeRegistry->id())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new SalonService())->deleteSpecializations($args['salon_id'], $args['specializations_id'] ?? []);
                }
            ],
        ];
    }

}