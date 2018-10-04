<?php

namespace api\graphql\site\types\entity;

use common\models\SalonService;
use common\models\Service;
use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;

/**
 * Class ServiceType
 * @package api\graphql\site\types\entity
 */
class ServiceType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'serviceByAccountId' => [
                'type' => $typeRegistry->listOff($entityRegistry->service()),
                'description' => 'Сервисы этого мастера',
                'args' => [
                    'account_id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id())
                    ],
                    'salon_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                ],
                'resolve' => function ($root, $args) {
                    if (empty($args['salon_id'])) {
                        return Service::find()->byAccountId($args['account_id'])->all();
                    }

                    return Service::find()
                        ->alias('s')
                        ->leftJoin(SalonService::tableName() . ' ss', 's.id = ss.service_id')
                        ->where(['ss.salon_id' => $args['salon_id']])
                        ->andWhere(['s.account_id' => $args['account_id']])
                        ->all();
                }
            ],
        ];
    }
}