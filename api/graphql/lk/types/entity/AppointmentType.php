<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Deferred;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
use api\models\lk\Client;
use common\models\Appointment;
use api\models\lk\AppointmentItem;
use GraphQL\Type\Definition\InputObjectType;
use yii\helpers\ArrayHelper;

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
        $filterType = new InputObjectType([
            'name' => 'AppointmentFilter',
            'fields' => function () use ($typeRegistry) {
                return [
                    'start_date' => $typeRegistry->date(),
                    'end_date' => $typeRegistry->date(),
                    'start_time' => $typeRegistry->dateTime(),
                    'end_time' => $typeRegistry->dateTime(),
                    'user_id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                ];
            }
        ]);

        return [
            'appointments' => [
                'type' => $typeRegistry->listOff($entityRegistry->appointment()),
                'description' => 'Коллекция записей',
                'args' => [
                    'filter' => $filterType,
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0,
                    ],
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    $query = Appointment::find()->limit($args['limit'])->offset($args['offset']);

                    if ($startDate = ArrayHelper::getValue($args, 'filter.start_date', date('Y-m-d 00:00:00'))
                        && $endDate = ArrayHelper::getValue($args, 'filter.end_date', date('Y-m-d 23:59:59'))
                    ) {
                        $query->where(['between', 'start_date', $startDate, $endDate]);
                    }
                    
                    if ($startDate = ArrayHelper::getValue($args, 'filter.start_date', date('Y-m-d 00:00:00'))
                        && $endDate = ArrayHelper::getValue($args, 'filter.end_date', date('Y-m-d 23:59:59'))
                    ) {
                        $query->where(['between', 'start_date', $startDate, $endDate]);
                    }

                    if ($userId = ArrayHelper::getValue($args, 'filter.user_id')) {
                        $query->andFilterWhere(['user_id' => $userId]);
                    }
                    if ($salonId = ArrayHelper::getValue($args, 'filter.salon_id')) {
                        $query->andFilterWhere(['salon_id' => $salonId]);
                    }
                    if ($masterId = ArrayHelper::getValue($args, 'filter.master_id')) {
                        $query->andFilterWhere(['salon_id' => $masterId]);
                    }

                    return $query->all();



//                    return Appointment::find()
//                        ->where(['between', 'start_date', $args['filter']['start_date'], $args['filter']['end_date']])
//                        ->andFilterWhere(['user_id' => $args['filter']['user_id']])
//                        ->andFilterWhere(['salon_id' => $args['filter']['salon_id']])
//                        ->andFilterWhere(['master_id' => $args['filter']['master_id']])
//                        ->limit($args['limit'])
//                        ->offset($args['offset'])
//                        ->allByCurrentAccountId();
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