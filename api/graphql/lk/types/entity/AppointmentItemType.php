<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\Appointment;
use api\models\AppointmentItem;

/**
 * Class AppointmentItemType
 *
 * @package api\graphql\lk\types\entity
 */
class AppointmentItemType extends ObjectType implements QueryTypeInterface
{
    /**
     * AppointmentItemType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'appointment_id' => $typeRegistry->id(),
                    'service_id' => $typeRegistry->id(),
                    'service_name' => $typeRegistry->string(),
                    'service_price' => $typeRegistry->float(),
                    'service_duration' => $typeRegistry->int(),
                    'quantity' => $typeRegistry->int()
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
                        ->byAccountId('ai')
                        ->all();
                }
            ],
            'appointmentItem' => [
                'type' => $entityRegistry->appointmentItem(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return AppointmentItem::find()->oneById($args['id']);
                }
            ]
        ];
    }


}