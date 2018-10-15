<?php

namespace api\graphql\common\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use common\models\Master;
use common\models\SalonMaster;

/**
 * Class MasterType
 *
 * @package api\graphql\common\types\entity
 */
class MasterType implements QueryTypeInterface
{
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'masters' => [
                'type' => $typeRegistry->listOff($entityRegistry->master()),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return Master::find()
                        ->alias('t1')
                        ->leftJoin(SalonMaster::tableName() . ' t2', '`t1`.`id` = `t2`.`master_id`')
                        ->where(['t2.salon_id' => $args['salon_id']])
                        ->all();
                }
            ]
        ];
    }
}