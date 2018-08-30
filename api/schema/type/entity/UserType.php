<?php

namespace api\schema\type\entity;

use api\schema\type\QueryTypeInterface;
use GraphQL\Type\Definition\ObjectType;
use common\models\UserService;
use api\models\User;
use api\models\Service;
use api\schema\registry\TypeRegistry;
use api\models\UserSchedule;

/**
 * Class UserType
 *
 * @package api\schema\type\entity
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
        $entityRegistry = $typeRegistry->getEntityRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'type' => $typeRegistry->int(),
                    'login' => $typeRegistry->string(),
                    'profile' => [
                        'type' => $entityRegistry->userProfile(),
                        'description' => 'Профиль',
                        'resolve' => function (User $user, $args, $context, $info) {
                            return $user->profile;
                        }
                    ],
                    'specializations' => [
                        'type' => $typeRegistry->listOff($entityRegistry->specialization()),
                        'description' => 'Коллекция специализаций',
                        'resolve' => function (User $user, $args) {
                            return $user->specializations;
                        }
                    ],
                    'conveniences' => [
                        'type' => $typeRegistry->listOff($entityRegistry->convenience()),
                        'description' => 'Коллекция удобств',
                        'resolve' => function (User $user, $args) {
                            return $user->conveniences;
                        }
                    ],
                    'schedule' => [
                        'type' => $typeRegistry->listOff($entityRegistry->userSchedule()),
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

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'user' => [
                'type' => $entityRegistry->user(),
                'description' => 'Пользователь',
                'resolve' => function ($root, $args, $context, $info) {
                    return User::find()->currentUser();
                }
            ]
        ];
    }
}