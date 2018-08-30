<?php

namespace api\schema\type\query;

use api\exceptions\AttributeValidationError;
use api\exceptions\ValidationError;
use api\models\Convenience;
use api\models\SalonUser;
use api\models\UserService;
use api\models\Service;
use api\models\Specialization;
use api\models\User;
use api\models\UserSchedule;
use common\models\SalonConvenience;
use common\models\SalonSpecialization;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use api\schema\TypeRegistry;
use api\repositories\SalonRepository;
use api\models\Salon;

/**
 * Class SalonType
 * @package api\schema\query
 */
class SalonType extends ObjectType implements QueryTypeInterface
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $queryRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'name' => $typeRegistry->string(),
                    'user_id' => $typeRegistry->id(),
                    'specializations' => [
                        'type' => $typeRegistry->listOff($queryRegistry->specialization()),
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
                        'type' => $typeRegistry->listOff($queryRegistry->convenience()),
                        'description' => 'Коллекция удобств',
                        'resolve' => function (Salon $salon, $args, $context, $info) {
                            return Convenience::find()
                                ->alias('c')
                                ->leftJoin(SalonConvenience::tableName() . 'sc', '`c`.`id` = `sc`.`convenience_id`')
                                ->where(['sc.salon_id' => $salon->id])
                                ->all();
                        }
                    ],
                    'users' => [
                        'type' => $typeRegistry->listOff($queryRegistry->user()),
                        'description' => 'Коллекция пользователей',
                        'resolve' => function (Salon $salon, $args, $context, $info) {
                            return User::find()
                                ->alias('u')
                                ->leftJoin(SalonUser::tableName() . ' su', '`u`.`id` = `su`.`user_id`')
                                ->where(['su.salon_id' => $salon->id])
                                ->isAccount('u')
                                ->all();
                        }
                    ],
                    'userSchedules' => [
                        'type' => $typeRegistry->listOff($queryRegistry->userSchedule()),
                        'args' => [
                            'user_id' => [
                                'type' => $typeRegistry->id(),
                                'defaultValue' => null
                            ],
                            'start_date' => [
                                'type' => $typeRegistry->dateTime(),
                                'description' => 'Дата начала, формат "Y-m-d H:i:s"',
                                'defaultValue' => date('Y-m-01 00:00:00')
                            ],
                            'end_date' => [
                                'type' => $typeRegistry->dateTime(),
                                'description' => 'Дата окончания, формат "Y-m-d H:i:s"',
                                'defaultValue' => date('Y-m-t 23:59:59')
                            ],
                        ],
                        'resolve' => function (Salon $model, $args) {
                            return UserSchedule::find()
                                ->alias('us')
                                ->leftJoin(SalonUser::tableName() . ' su', '`us`.`user_id` = `su`.`user_id`')
                                ->where(['su.salon_id' => $model->id])
                                ->andWhere(['between', 'us.start_date', $args['start_date'], $args['end_date']])
                                ->andFilterWhere(['us.user_id' => $args['user_id']])
                                ->all();
                        }
                    ],
                    'salonUserServices' => [
                        'type' => $typeRegistry->listOff($queryRegistry->salonUserService()),
                        'args' => [
                            'user_id' => $typeRegistry->nonNull($typeRegistry->id())
                        ],
                        'resolve' => function (Salon $model, $args) {
                            return UserService::find()
                                ->where(['salon_id' => $model->id, 'user_id' => $args['user_id']])
                                ->isAccount()
                                ->all();
                        }
                    ],
                    'userServices' => [
                        'type' => $typeRegistry->listOff($queryRegistry->service()),
                        'args' => [
                            'user_id' => $typeRegistry->nonNull($typeRegistry->id())
                        ],
                        'resolve' => function (Salon $model, $args) {
                            return Service::find()
                                ->alias('s')
                                ->leftJoin(UserService::tableName() . ' sus', '`s`.`id` = `sus`.`service_id`')
                                ->where(['sus.salon_id' => $model->id, 'sus.user_id' => $args['user_id']])
                                ->isAccount('s')
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
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'salons' => [
                'type' => $typeRegistry->listOff($queryRegistry->salon()),
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
                'type' => $queryRegistry->salon(),
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