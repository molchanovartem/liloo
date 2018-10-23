<?php

namespace api\graphql\lk\types\entity;

use common\models\User;
use api\graphql\core\QueryTypeInterface;
use api\graphql\core\TypeRegistry;
use api\models\lk\UserSchedule;

/**
 * Class UserType
 *
 * @package api\schema\type\entity
 */
class UserType extends \api\graphql\base\types\entity\UserType implements QueryTypeInterface
{
    public function fields(): array
    {
        return array_merge(parent::fields(), [
            'schedule' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->userSchedule()),
                'description' => 'Коллекция расписания',
                'args' => [
                    'start_date' => [
                        'type' => $this->typeRegistry->dateTime(),
                        'description' => 'Дата начала, формат "Y-m-d H:i:s"',
                        'defaultValue' => date('Y-m-01 00:00:00')
                    ],
                    'end_date' => [
                        'type' => $this->typeRegistry->dateTime(),
                        'description' => 'Дата окончания, формат "Y-m-d H:i:s"',
                        'defaultValue' => date('Y-m-t 23:59:59')
                    ],
                ],
                'resolve' => function (User $user, $args, $context, $info) {
                    return UserSchedule::find()
                        ->where(['between', 'start_date', $args['start_date'], $args['end_date']])
                        ->byCurrentUserId()
                        ->all();
                }
            ]
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