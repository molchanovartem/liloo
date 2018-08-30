<?php

namespace api\schema\type\query;

use api\models\Client;
use GraphQL\Deferred;
use GraphQL\Type\Definition\ObjectType;
use api\models\Appointment;
use api\models\AppointmentItem;
use api\schema\TypeRegistry;

/**
 * Class AppointmentType
 *
 * @package api\schema\query
 */
class AppointmentType extends ObjectType implements QueryTypeInterface
{
    /**
     * AppointmentType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $queryRegistry) {
                return [
                    'id' => $typeRegistry->int(),
                    'account_id' => $typeRegistry->int(),
                    'user_id' => $typeRegistry->int(),
                    'salon_id' => $typeRegistry->int(),
                    'owner_id' => $typeRegistry->int(),
                    'client_id' => $typeRegistry->int(),
                    'status' => $typeRegistry->int(),
                    'start_date' => $typeRegistry->dateTime(),
                    'end_date' => $typeRegistry->dateTime(),
                    'client' => [
                        'type' => $queryRegistry->client(),
                        'resolve' => function (Appointment $model, $args) {
                            Client::buffer()->addKey($model->client_id);

                            return new Deferred(function () use ($model, $args) {
                                return Client::buffer()->oneById($model->client_id);
                            });
                        }
                    ],
                    'items' => [
                        'type' => $typeRegistry->listOff($queryRegistry->appointmentItem()),
                        'description' => 'Коллекция услуг',
                        'resolve' => function ($model, $args, $context, $info) {
                            AppointmentItem::buffer()->addKey($model->id);

                            return new Deferred(function () use ($model, $args) {
                                return AppointmentItem::buffer()->allByAppointmentId($model->id);
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
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'appointments' => [
                'type' => $typeRegistry->listOff($queryRegistry->appointment()),
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
                    ]
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return Appointment::find()->allByParams($args['start_date'], $args['end_date'], $args['user_id'], $args['salon_id']);
                }
            ],
            'appointment' => [
                'type' => $queryRegistry->appointment(),
                'description' => 'Запись',
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return Appointment::find()->oneById($args['id']);
                }
            ]
        ];
    }
}