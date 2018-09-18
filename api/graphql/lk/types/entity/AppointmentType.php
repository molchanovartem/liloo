<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Deferred;
use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\Client;
use api\models\Appointment;
use api\models\AppointmentItem;

/**
 * Class AppointmentType
 *
 * @package api\graphql\lk\types\entity
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
        $entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'user_id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'client_id' => $typeRegistry->id(),
                    'owner_id' => $typeRegistry->id(),
                    'status' => $typeRegistry->int(),
                    'start_date' => $typeRegistry->dateTime(),
                    'end_date' => $typeRegistry->dateTime(),
                    'client' => [
                        'type' => $entityRegistry->client(),
                        'resolve' => function (Appointment $model, $args) {
                            Client::buffer()->addKey($model->client_id);

                            return new Deferred(function () use ($model, $args) {
                                return Client::buffer()->oneById($model->client_id);
                            });
                        }
                    ],
                    'items' => [
                        'type' => $typeRegistry->listOff($entityRegistry->appointmentItem()),
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
                    return Appointment::find()->allByParams($args['start_date'], $args['end_date'], $args['user_id'], $args['salon_id'], $args['master_id']);
                }
            ],
            'appointment' => [
                'type' => $entityRegistry->appointment(),
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