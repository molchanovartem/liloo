<?php

namespace api\schema\type\mutation\salon;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\SalonService;

/**
 * Class SalonSpecializationType
 *
 * @package api\schema\type\mutation\salon
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