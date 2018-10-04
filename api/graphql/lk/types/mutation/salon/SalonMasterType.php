<?php

namespace api\graphql\lk\types\mutation\salon;

use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;
use api\services\lk\SalonService;

/**
 * Class SalonMasterType
 *
 * @package api\graphql\lk\types\mutation\salon
 */
class SalonMasterType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'salonMasterCreate' => [
                'type' => $entityRegistry->salonMaster(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->createSalonMaster($args['salon_id'], $args['master_id']);
                }
            ],
            'salonMastersCreate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'masters_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->createSalonMasters($args['salon_id'], $args['masters_id']);
                }
            ],
            'salonMastersUpdate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'masters_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->updateSalonMasters($args['salon_id'], $args['masters_id']);
                }
            ],
            'salonMasterDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->deleteSalonMaster($args['salon_id'], $args['master_id']);
                }
            ],
            'salonMastersDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'masters_id' => [
                        'type' => $typeRegistry->listOff($typeRegistry->id()),
                        'defaultValue' => []
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->deleteMasters($args['salon_id'], $args['masters_id']);
                }
            ]
        ];
    }
}