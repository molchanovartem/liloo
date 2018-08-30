<?php

namespace api\schema\type\query;

use GraphQL\Type\Definition\ObjectType;
use common\models\UserService;
use api\models\User;
use api\models\Service;
use api\schema\TypeRegistry;
use api\models\UserSchedule;

/**
 * Class UserType
 *
 * @package api\schema\query
 */
class UserType extends ObjectType implements QueryTypeInterface
{
    /**
     * UserType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $queryRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'type' => $typeRegistry->int(),
                    'login' => $typeRegistry->string(),
                    'profile' => [
                        'type' => $queryRegistry->userProfile(),
                        'description' => 'Профиль',
                        'resolve' => function (User $user, $args, $context, $info) {
                            return $user->profile;
                        }
                    ],
                    'specializations' => [
                        'type' => $typeRegistry->listOff($queryRegistry->specialization()),
                        'description' => 'Коллекция специализаций',
                        'resolve' => function (User $user, $args) {
                            return $user->specializations;
                        }
                    ],
                    'conveniences' => [
                        'type' => $typeRegistry->listOff($queryRegistry->convenience()),
                        'description' => 'Коллекция удобств',
                        'resolve' => function (User $user, $args) {
                            return $user->conveniences;
                        }
                    ],
                    'services' => [
                        'type' => $typeRegistry->listOff($queryRegistry->service()),
                        'description' => 'Коллекций услуг',
                        'args' => [
                            'salon_id' => $typeRegistry->nonNull($typeRegistry->id())
                        ],
                        'resolve' => function (User $user, $args) {
                            return Service::find()
                                ->alias('s')
                                ->leftJoin(UserService::tableName() . ' sus', '`s`.`id` = `sus`.`service_id`')
                                ->where(['sus.user_id' => $user['id'], 'sus.salon_id' => $args['salon_id']])
                                ->isAccount('s')
                                ->all();
                        }
                    ],
                    'schedule' => [
                        'type' => $typeRegistry->listOff($queryRegistry->userSchedule()),
                        'description' => 'Коллекция расписания',
                        'args' => [
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
                        'resolve' => function (User $user, $args, $context, $info) {
                            return UserSchedule::find()->allByParams($user->id, $args['start_date'], $args['end_date']);
                        }
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }

    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'user' => [
                'type' => $queryRegistry->user(),
                'description' => 'Пользователь',
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return User::find()->oneById($args['id']);
                }
            ],
            'userServices' => [
                'type' => $typeRegistry->listOff($queryRegistry->service()),
                'description' => 'Коллекция услуг',
                'args' => [
                    'user_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return Service::find()
                        ->alias('s')
                        ->leftJoin(UserService::tableName() . ' sus', '`s`.`id` = `sus`.`service_id`')
                        ->where(['sus.user_id' => $args['user_id'], 'sus.salon_id' => $args['salon_id']])
                        ->isAccount('s')
                        ->all();
                }
            ]
        ];
    }
}