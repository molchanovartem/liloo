<?php

namespace api\services;

use Yii;
use yii\db\Exception;
use api\models\Salon;
use api\models\User;
use api\exceptions\AttributeValidationError;
use api\exceptions\NotFoundEntryError;
use api\models\Appointment;
use api\models\AppointmentItem;
use api\models\Service;
use api\models\SalonService;

/**
 * Class AppointmentService
 *
 * @package api\services
 */
class AppointmentService extends \api\services\Service
{
    /**
     * @param array $attributes
     * @return null
     * @throws Exception
     */
    public function create(array $attributes)
    {
        $accountId = null;
        if (!empty($attributes['user_id'])) {
            $accountId = ($user = User::find()->oneById($attributes['user_id'])) ? $user->account_id : null;
        } else if ($attributes['salon_id']) {
            $accountId = ($salon = Salon::find()->oneById($attributes['salon_id'])) ? $salon->account_id : null;
        }

        return $this->save(new Appointment([
            'account_id' => $accountId
        ]), $attributes);
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
        if (!$model = Appointment::find()->oneById($id)) throw new NotFoundEntryError();

        return $this->save($model, $attributes);
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

            $model->save(false);

            if (!empty($attributes['items'])) {
                if (!$model->isNewRecord) {
                    AppointmentItem::deleteAll([
                        'appointment_id' => $model->id,
                        'account_id' =>$model->account_id
                    ]);
                }
                $this->saveItems($model, $attributes['items']);
            }
            return $model;
        });
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
        if (!$model = Appointment::find()->oneById($id)) throw new NotFoundEntryError();

        return (bool)$model->delete();
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
            ->asArray()
            ->indexBy('id')
            ->andWhere(['account_id' => $appointment->account_id])
            ->allByIdInService(array_column($items, 'service_id'));

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
        return (bool) Yii::$app->db->createCommand()->batchInsert(AppointmentItem::tableName(), $attributes, $batch)
            ->execute();
    }
}