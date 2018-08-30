<?php

namespace api\schema\type\mutation\salon;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\SalonService;

/**
 * Class SalonConvenienceType
 *
 * @package api\schema\type\mutation\salon
 */
class SalonConvenienceType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        return [
            'salonConveniencesUpdate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'conveniences_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new SalonService())->updateConveniences($args['salon_id'], $args['conveniences_id']);
                }
            ],
            'salonConveniencesDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'conveniences_id' => $typeRegistry->listOff($typeRegistry->id())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new SalonService())->deleteConveniences($args['salon_id'], $args['conveniences_id'] ?? []);
                }
            ],
        ];
    }

}