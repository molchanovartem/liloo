<?php

namespace api\graphql\lk\types\entity;

use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\lk\SalonMaster;

/**
 * Class SalonMasterType
 *
 * @package api\graphql\lk\types\entity
 */
class SalonMasterType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'salonMasters' => [
                'type' => $typeRegistry->listOff($entityRegistry->salonMaster()),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                ],
                'resolve' => function ($root, $args) {
                    return SalonMaster::find()
                        ->bySalonId($args['salon_id'])
                        ->allByCurrentAccountId();
                }
            ]
        ];
    }
}