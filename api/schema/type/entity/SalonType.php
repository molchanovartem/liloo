<?php

namespace api\schema\type\entity;

use api\models\Master;
use api\models\SalonMaster;
use GraphQL\Type\Definition\ObjectType;
use common\models\SalonConvenience;
use common\models\SalonSpecialization;
use api\models\Convenience;
use api\models\Specialization;
use api\schema\type\QueryTypeInterface;
use api\schema\registry\TypeRegistry;
use api\models\Salon;

/**
 * Class SalonType
 * @package api\schema\query
 */
class SalonType extends ObjectType implements QueryTypeInterface
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'user_id' => $typeRegistry->id(),
                    'country_id' => $typeRegistry->id(),
                    'city_id' => $typeRegistry->id(),
                    'status' => $typeRegistry->int(),
                    'name' => $typeRegistry->string(),
                    'address' => $typeRegistry->string(),
                    'specializations' => [
                        'type' => $typeRegistry->listOff($entityRegistry->specialization()),
                        'description' => 'Коллекция специализаций',
                        'resolve' => function (Salon $salon, $args, $context, $info) {
                            return Specialization::find()
                                ->alias('s')
                                ->leftJoin(SalonSpecialization::tableName() . 'ss', '`s`.`id` = `ss`.`specialization_id`')
                                ->where(['ss.salon_id' => $salon->id])
                                ->all();
                        }
                    ],
                    'conveniences' => [
                        'type' => $typeRegistry->listOff($entityRegistry->convenience()),
                        'description' => 'Коллекция удобств',
                        'resolve' => function (Salon $salon, $args, $context, $info) {
                            return Convenience::find()
                                ->alias('c')
                                ->leftJoin(SalonConvenience::tableName() . 'sc', '`c`.`id` = `sc`.`convenience_id`')
                                ->where(['sc.salon_id' => $salon->id])
                                ->all();
                        }
                    ],
                    'masters' => [
                        'type' => $typeRegistry->listOff($entityRegistry->master()),
                        'resolve' => function (Salon $model, $args) {
                            return Master::find()
                                ->alias('m')
                                ->leftJoin(SalonMaster::tableName() . ' sm', '`m`.`id` = `sm`.`master_id`')
                                ->where(['sm.salon_id' => $model->id])
                                ->byAccountId('m')
                                ->all();
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'salons' => [
                'type' => $typeRegistry->listOff($entityRegistry->salon()),
                'description' => 'Коллекция салонов',
                'args' => [
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Salon::find()->allByParams($args['limit'], $args['offset']);
                }
            ],
            'salon' => [
                'type' => $entityRegistry->salon(),
                'description' => 'Салон',
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return Salon::find()->oneById($args['id']);
                }
            ],
        ];
    }


}