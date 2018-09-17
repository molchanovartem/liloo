<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Deferred;
use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\MasterService;
use api\models\SalonService;
use api\models\Service;

/**
 * Class SalonServiceType
 *
 * @package api\schema\type\entity
 */
class SalonServiceType extends ObjectType implements QueryTypeInterface
{
    /**
     * SalonServiceType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
                    'service_id' => $typeRegistry->id(),
                    'service_price' => $typeRegistry->decimal(),
                    'service_duration' => $typeRegistry->int(),
                    'service' => [
                        'type' => $entityRegistry->service(),
                        'resolve' => function (SalonService $model, $args) {
                            Service::buffer()->addKey($model->service_id);

                            return new Deferred(function () use ($model, $args) {
                                return Service::buffer()->oneServiceById($model->service_id);
                            });
                        }
                    ]
                ];
            }
        ]);
    }

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
                    return SalonService::find()->allBySalonId($args['salon_id']);
                }
            ],
            'salonService' => [
                'type' => $entityRegistry->salonService(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return SalonService::find()->oneById($args['id']);
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
                        ->byAccountId('ss')
                        ->all();
                }
            ]
        ];
    }

}