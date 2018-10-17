<?php

namespace api\graphql\common\types\entity;

use common\models\SalonService;
use common\models\Service;
use common\models\User;
use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;

/**
 * Class ServiceType
 *
 * @package api\graphql\common\types\entity
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
            'servicesUser' => [
                'type' => $typeRegistry->listOff($entityRegistry->service()),
                'description' => 'Сервисы мастера',
                'args' => [
                    'user_id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id())
                    ],
                ],
                'resolve' => function ($root, $args) {
                    if ($user = User::find()->oneById($args['user_id'])) {
                        return Service::find()->byAccountId($user->account_id)->all();
                    }
                    return null;
                }
            ],
            'servicesSalon' => [
                'type' => $typeRegistry->listOff($entityRegistry->service()),
                'description' => 'Сервисы салона',
                'args' => [
                    'salon_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                ],
                'resolve' => function ($root, $args) {
                    return Service::find()
                        ->alias('s')
                        ->leftJoin(SalonService::tableName() . ' ss', 's.id = ss.service_id')
                        ->where(['ss.salon_id' => $args['salon_id']])
                        ->all();
                }
            ],
        ];
    }
}