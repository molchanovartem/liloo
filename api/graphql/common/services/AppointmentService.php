<?php

namespace api\graphql\common\services;

use Yii;
use yii\db\Query;
use yii\db\Exception;
use common\core\service\ModelService;
use common\models\Appointment;
use common\models\SalonService;
use common\models\AppointmentItem;
use api\graphql\core\errors\ValidationError;
use api\graphql\core\errors\AttributeValidationError;
use api\graphql\core\errors\NotFoundEntryError;
use api\models\lk\Service;


/**
 * Class AppointmentService
 *
 * @package api\graphql\common\services
 */
abstract class AppointmentService extends ModelService
{
    /**
     * @param Appointment $model
     * @param array $attributes
     * @return null
     * @throws \Exception
     */
    protected function save($model, array $attributes)
    {
        return $this->wrappedTransaction(function () use ($model, $attributes) {
            $model->setAttributes($attributes);

            if (!$model->validate()) throw new AttributeValidationError($model->getErrors());
            if (!$this->validateSchedulesDate($model)) throw new ValidationError('Не рабочее время');
            if ($this->validateAppointmentDate($model)) throw new ValidationError('Это время занято');

            $model->save(false);

            if (!empty($attributes['items'])) {
                $this->saveItems($model, $attributes['items']);
            }
            return $model;
        });
    }

    /**
     * @param $attributes
     * @return bool
     */
    private function validateSchedulesDate($model)
    {
        if (!empty($model['master_id']) && !empty($model['salon_id'])) {
            $schedules = (new Query())->select(['start_date', 'end_date'])
                ->from('{{%master_schedule}}')
                ->where(['master_id' => $model['master_id']])
                ->andWhere(['salon_id' => $model['salon_id']])
                ->andWhere(['and',
                    ['<=', 'start_date', $model['start_date']],
                    ['>=', 'end_date', $model['start_date']],
                ])
                ->andWhere(['and',
                    ['<=', 'start_date', $model['end_date']],
                    ['>=', 'end_date', $model['end_date']],
                ])
                ->all();
        } else {
            $schedules = (new Query())->select(['start_date', 'end_date'])
                ->from('{{%user_schedule}}')
                ->where(['user_id' => $model['user_id']])
                ->andWhere(['and',
                    ['<=', 'start_date', $model['start_date']],
                    ['>=', 'end_date', $model['start_date']],
                ])
                ->andWhere(['and',
                    ['<=', 'start_date', $model['end_date']],
                    ['>=', 'end_date', $model['end_date']],
                ])
                ->all();
        }

        return (bool) count($schedules);
    }

    /**
     * @param $attributes
     * @return bool
     */
    private function validateAppointmentDate($model)
    {
        if (!empty($attributes['master_id']) && !empty($model['salon_id'])) {
            $appointmentDates = (new Query())->select(['start_date', 'end_date'])
                ->from('{{%appointment}}')
                ->where(['and',
                    ['<=', 'start_date', $model['start_date']],
                    ['>', 'end_date', $model['start_date']],
                ])
                ->orWhere(['and',
                    ['<=', 'start_date', $model['end_date']],
                    ['>=', 'end_date', $model['end_date']],
                ])
                ->orWhere(['and',
                    ['>=', 'start_date', $model['start_date']],
                    ['<=', 'end_date', $model['end_date']],
                ])
                ->andWhere(['and',
                    ['master_id' => $model['master_id']],
                    ['salon_id' => $model['salon_id']],
                ])
                ->andFilterWhere(['!=', 'id', $model['id'] ?? null])
                ->andWhere(['in', 'status', [Appointment::STATUS_NEW, Appointment::STATUS_COMPLETED, Appointment::STATUS_CONFIRMED]])
                ->all();
        } else {
            $appointmentDates = (new Query())->select(['start_date', 'end_date'])
                ->from('{{%appointment}}')
                ->where(['and',
                    ['<=', 'start_date', $model['start_date']],
                    ['>', 'end_date', $model['start_date']],
                ])
                ->orWhere(['and',
                    ['<=', 'start_date', $model['end_date']],
                    ['>=', 'end_date', $model['end_date']],
                ])
                ->orWhere(['and',
                    ['>=', 'start_date', $model['start_date']],
                    ['<=', 'end_date', $model['end_date']],
                ])
                ->andWhere(['user_id' => $model['user_id']])
                ->andFilterWhere(['!=', 'id', $model['id'] ?? null])
                ->andWhere(['in', 'status', [Appointment::STATUS_NEW, Appointment::STATUS_COMPLETED, Appointment::STATUS_CONFIRMED]])
                ->all();
        }

        return (bool) count($appointmentDates);
    }

    /**
     * @param $appointment
     * @param array $items
     * @return bool
     * @throws AttributeValidationError
     * @throws Exception
     * @throws NotFoundEntryError
     */
    private function saveItems($appointment, array $items): bool
    {
        /*
         * @todo
         * Не нравится, какой-то говнокод, отрефакторить
         */
        $services = Service::find()
            ->byId(array_column($items, 'service_id'))
            ->isService()
            ->asArray()
            ->indexBy('id')
            ->byAccountId($appointment->account_id)
            ->all();

        $salonServices = [];
        if ($appointment->salon_id !== null) {
            $salonServices = SalonService::find()
                ->where(['salon_id' => $appointment->salon_id])
                ->andWhere(['in', 'service_id', array_column($items, 'service_id')])
                ->andWhere(['account_id' => $appointment->account_id])
                ->indexBy('service_id')
                ->asArray()
                ->all();
        }

        $attributes = ['account_id', 'appointment_id', 'service_id', 'service_name', 'service_price', 'service_duration', 'quantity'];
        $batch = [];
        $models = [];
        foreach ($items as $key => $item) {
            if (empty($services[$item['service_id']])) throw new NotFoundEntryError('Not found entry service');

            $models[$key] = new AppointmentItem([
                'account_id' => $appointment->account_id,
                'appointment_id' => $appointment->id,
                'service_id' => $item['service_id'],
                'service_name' => $services[$item['service_id']]['name'],
                'service_price' => $appointment->salon_id ? $salonServices[$item['service_id']]['service_price'] : $services[$item['service_id']]['price'],
                'service_duration' => $appointment->salon_id ? $salonServices[$item['service_id']]['service_duration'] : $services[$item['service_id']]['duration'],
                'quantity' => $item['quantity']
            ]);
            $models[$key]->setAttributes($item);
            if (!$models[$key]->validate()) throw new AttributeValidationError($models[$key]->getErrors());

            $batch[] = $models[$key]->getAttributes($attributes);
        }
        return (bool)Yii::$app->db->createCommand()->batchInsert(AppointmentItem::tableName(), $attributes, $batch)
            ->execute();
    }
}