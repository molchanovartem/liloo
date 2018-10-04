<?php

namespace api\graphql\lk\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\lk\Appointment;
use common\models\AppointmentItem;

/**
 * Class AppointmentItemType
 *
 * @package api\graphql\lk\types\entity
 */
class AppointmentItemType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'appointmentItems' => [
                'type' => $typeRegistry->listOff($entityRegistry->appointmentItem()),
                'args' => [
                    'appointment_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return AppointmentItem::find()
                        ->alias('ai')
                        ->leftJoin(Appointment::tableName(). ' a', '`a`.`id` = `ai`.`appointment_id`')
                        ->where(['ai.id' => $args['appointment_id']])
                        ->byCurrentAccountId('ai')
                        ->all();
                }
            ],
            'appointmentItem' => [
                'type' => $entityRegistry->appointmentItem(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return AppointmentItem::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ]
        ];
    }
}