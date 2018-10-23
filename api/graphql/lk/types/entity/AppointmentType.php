<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Deferred;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
use api\models\lk\Client;
use common\models\Appointment;
use api\models\lk\AppointmentItem;

/**
 * Class AppointmentType
 *
 * @package api\graphql\lk\types\entity
 */
class AppointmentType extends \api\graphql\base\types\entity\AppointmentType implements QueryTypeInterface
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return array_merge(parent::fields(), [
            'client' => [
                'type' => $this->entityRegistry->client(),
                'resolve' => function (Appointment $model, $args) {
                    Client::buffer()->addKey($model->client_id);

                    return new Deferred(function () use ($model, $args) {
                        return Client::buffer()->oneById($model->client_id);
                    });
                }
            ],
            'items' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->appointmentItem()),
                'resolve' => function ($model, $args, $context, $info) {
                    AppointmentItem::buffer()->addKey($model->id);

                    return new Deferred(function () use ($model, $args) {
                        return AppointmentItem::buffer()->allByAppointmentId($model->id);
                    });
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
            'appointments' => [
                'type' => $typeRegistry->listOff($entityRegistry->appointment()),
                'description' => 'Коллекция записей',
                'args' => [
                    'start_date' => [
                        'type' => $typeRegistry->dateTime(),
                        'description' => 'Дата начала, фомат "Y-m-d H:i:s"',
                        'defaultValue' => date('Y-m-01 00:00:00')
                    ],
                    'end_date' => [
                        'type' => $typeRegistry->dateTime(),
                        'description' => 'Дата окончания, фомат "Y-m-d H:i:s"',
                        'defaultValue' => date('Y-m-t 23:59:59')
                    ],
                    'user_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null
                    ],
                    'salon_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null
                    ],
                    'master_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null
                    ]
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return Appointment::find()
                        ->where(['between', 'start_date', $args['start_date'], $args['end_date']])
                        ->andFilterWhere(['user_id' => $args['user_id']])
                        ->andFilterWhere(['salon_id' => $args['salon_id']])
                        ->andFilterWhere(['master_id' => $args['master_id']])
                        ->allByCurrentAccountId();
                }
            ],
            'appointment' => [
                'type' => $entityRegistry->appointment(),
                'description' => 'Запись',
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return Appointment::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ]
        ];
    }
}