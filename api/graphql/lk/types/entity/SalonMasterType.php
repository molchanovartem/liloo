<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
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
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0
                    ],
                ],
                'resolve' => function ($root, $args) {
                    return SalonMaster::find()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->bySalonId($args['salon_id'])
                        ->allByCurrentAccountId();
                }
            ]
        ];
    }
}