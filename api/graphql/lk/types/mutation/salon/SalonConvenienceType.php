<?php

namespace api\graphql\lk\types\mutation\salon;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\SalonService;

/**
 * Class SalonConvenienceType
 *
 * @package api\graphql\lk\types\mutation\salon
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