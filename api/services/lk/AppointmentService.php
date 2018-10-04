<?php

namespace api\services\lk;

use Yii;
use yii\db\Query;
use yii\db\Exception;
use api\graphql\errors\ValidationError;
use api\graphql\errors\AttributeValidationError;
use api\graphql\errors\NotFoundEntryError;
use api\models\lk\Appointment;
use api\models\lk\AppointmentItem;
use api\models\lk\Service;
use common\models\SalonService;

/**
 * Class AppointmentService
 *
 * @package api\services\lk
 */
class AppointmentService extends \api\services\Service
{
    /**
     * @param array $attributes
     * @return null
     * @throws AttributeValidationError
     * @throws Exception
     */
    public function create(array $attributes)
    {
        return $this->save(new Appointment(), $attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return null
     * @throws Exception
     * @throws NotFoundEntryError
     */
    public function update(int $id, array $attributes)
    {
        return $this->save($this->getAppointmentModel($id), $attributes);
    }

    /**
     * @param Appointment $model
     * @param array $attributes
     * @return null
     * @throws Exception
     */
    private function save(Appointment $model, array $attributes)
    {
        return $this->wrappedTransaction(function () use ($model, $attributes) {
            $model->setAttributes($attributes);

            if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

            if (!$this->validateSchedulesDate($model)) throw new ValidationError('Не рабочее время');
            if (!$this->validateAppointmentDate($model)) throw new ValidationError('Это время занято');

            $model->save(false);

            if (!empty($attributes['items'])) {
                if (!$model->isNewRecord) {
                    AppointmentItem::deleteAll([
                        'appointment_id' => $model->id,
                        'account_id' => $model->account_id
                    ]);
                }
                $this->saveItems($model, $attributes['items']);
            }
            return $model;
        });
    }

    /**
     * @param $attributes
     * @return bool
     */
    public function validateSchedulesDate($attributes)
    {
        if ($attributes['master_id']) {
            $schedules = (new Query())->select(['start_date', 'end_date'])
                ->from('{{%master_schedule}}')
                ->where(['master_id' => $attributes['master_id']])
                ->andWhere(['salon_id' => $attributes['salon_id']])
                ->andWhere(['and',
                    ['<=', 'start_date', $attributes['start_date']],
                    ['>=', 'end_date', $attributes['start_date']],
                ])
                ->andWhere(['and',
                    ['<=', 'start_date', $attributes['end_date']],
                    ['>=', 'end_date', $attributes['end_date']],
                ])
                ->all();
        } else {
              $schedules = (new Query())->select(['start_date', 'end_date'])
                ->from('{{%user_schedule}}')
                ->where(['user_id' => $attributes['user_id']])
                ->andWhere(['and',
                    ['<=', 'start_date', $attributes['start_date']],
                    ['>=', 'end_date', $attributes['start_date']],
                ])
                ->andWhere(['and',
                    ['<=', 'start_date', $attributes['end_date']],
                    ['>=', 'end_date', $attributes['end_date']],
                ])
                ->all();
        }

        if (count($schedules)) {
            return true;
        }

        return false;
    }

    /**
     * @param $attributes
     * @return bool
     */
    public function validateAppointmentDate($attributes)
    {
        if ($attributes['master_id']) {
            $appointmentDates = (new Query())->select(['start_date', 'end_date'])
                ->from('{{%appointment}}')
                ->where(['and',
                    ['<=', 'start_date', $attributes['start_date']],
                    ['>=', 'end_date', $attributes['start_date']],
                ])
                ->orWhere(['and',
                    ['<=', 'start_date', $attributes['end_date']],
                    ['>=', 'end_date', $attributes['end_date']],
                ])
                ->orWhere(['and',
                    ['>=', 'start_date', $attributes['start_date']],
                    ['<=', 'end_date', $attributes['end_date']],
                ])
                ->andWhere(['and',
                    ['master_id' => $attributes['master_id']],
                    ['salon_id' => $attributes['salon_id']],
                ])
                ->andFilterWhere(['!=', 'id', $attributes['id'] ?? null])
                ->all();
        } else {
            $appointmentDates = (new Query())->select(['start_date', 'end_date'])
                ->from('{{%appointment}}')
                ->where(['and',
                    ['<=', 'start_date', $attributes['start_date']],
                    ['>=', 'end_date', $attributes['start_date']],
                ])
                ->orWhere(['and',
                    ['<=', 'start_date', $attributes['end_date']],
                    ['>=', 'end_date', $attributes['end_date']],
                ])
                ->orWhere(['and',
                    ['>=', 'start_date', $attributes['start_date']],
                    ['<=', 'end_date', $attributes['end_date']],
                ])
                ->andWhere(['user_id' => $attributes['user_id']])
                ->andFilterWhere(['!=', 'id', $attributes['id'] ?? null])
                ->all();
        }

        if (count($appointmentDates)) {
            return false;
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws NotFoundEntryError
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete(int $id): bool
    {
        $model = $this->getAppointmentModel($id);

        return (bool)$model->delete();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundEntryError
     */
    private function getAppointmentModel(int $id)
    {
        $model = Appointment::find()
            ->byCurrentAccountId()
            ->oneById($id);

        if (!$model) throw new NotFoundEntryError();

        return $model;
    }

    /**
     * @param Appointment $appointment
     * @param array $items
     * @return bool
     * @throws AttributeValidationError
     * @throws Exception
     * @throws NotFoundEntryError
     */
    private function saveItems(Appointment $appointment, array $items): bool
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
            if (empty($services[$item['service_id']])) throw new NotFoundEntryError();

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