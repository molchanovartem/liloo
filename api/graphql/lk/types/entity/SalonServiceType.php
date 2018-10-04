<?php

namespace api\graphql\lk\types\entity;

use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\lk\MasterService;
use api\models\lk\SalonService;

/**
 * Class SalonServiceType
 *
 * @package api\schema\type\entity
 */
class SalonServiceType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'salonServices' => [
                'type' => $typeRegistry->listOff($entityRegistry->salonService()),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return SalonService::find()
                        ->bySalonId($args['salon_id'])
                        ->allByCurrentAccountId();
                }
            ],
            'salonService' => [
                'type' => $entityRegistry->salonService(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return SalonService::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ],
            'salonServicesForMaster' => [
                'type' => $typeRegistry->listOff($entityRegistry->salonService()),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return SalonService::find()
                        ->alias('ss')
                        ->leftJoin(MasterService::tableName() . ' ms', '`ss`.`service_id` = `ms`.`service_id`')
                        ->where([
                                'ss.salon_id' => $args['salon_id'],
                                'ms.salon_id' => $args['salon_id'],
                                'ms.master_id' => $args['master_id']
                            ]
                        )
                        ->byCurrentAccountId('ss')
                        ->all();
                }
            ]
        ];
    }

}