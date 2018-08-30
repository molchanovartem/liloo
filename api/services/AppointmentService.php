<?php

namespace api\services;

use GraphQL\Error\Error;
use Yii;
use yii\db\Exception;
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
     * Создает запись
     *
     * @param array $data
     * @return Appointment
     * @throws AttributeValidationError
     * @throws Exception
     */
    public function create(array $data)
    {
        $model = new Appointment();
        $model->setAttributes($data);

        $this->validate($model);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->save(false);

            if (!empty($data['items'])) $this->createItems($model->id, $data['items'], $model->salon_id);

            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }

        return $model;
    }

    /**
     * Обновляет запись
     *
     * @param int $id
     * @param array $data
     * @return array|null|\yii\db\ActiveRecord
     * @throws AttributeValidationError
     * @throws Exception
     * @throws NotFoundEntryError
     */
    public function update(int $id, array $data)
    {
        if (!$model = Appointment::find()->oneById($id)) throw new NotFoundEntryError();

        $model->setAttributes($data);

        $this->validate($model);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->save(false);

            if (!empty($data['items'])) $this->createItems($model->id, $data['items'], $model->salon_id);

            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }

        return $model;
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
     * @param Appointment $model
     * @throws AttributeValidationError
     */
    private function validate(Appointment $model)
    {
        /*
         * @todo
         * Добавить проверку доступность времени в текущем аккаунте
         */

        if (!$result = $model->validate()) throw new AttributeValidationError($model->getErrors());
    }

    /**
     * Сохраняет $items
     *
     * @param int $appointmentId
     * @param array $items
     * @param null $salonId
     * @return array
     * @throws AttributeValidationError
     * @throws Error
     * @throws Exception
     */
    public function createItems(int $appointmentId, array $items, $salonId = null)
    {
        $services = Service::find()
            ->asArray()
            ->indexBy('id')
            ->allByIdInService(array_column($items, 'service_id'));

        $salonServices = [];
        if ($salonId !== null) {
            $salonServices = SalonService::find()
                ->where(['salon_id' => $salonId])
                ->andWhere(['in', 'service_id', array_column($items, 'service_id')])
                ->byAccountId()
                ->indexBy('service_id')
                ->all();
        }

        $models = [];
        foreach ($items as $key => $item) {
            if (empty($services[$item['service_id']])) throw new Error('Not exist service_id');

            $models[$key] = new AppointmentItem([
                'appointment_id' => $appointmentId,
                'service_name' => $services[$item['service_id']]['name'],
                'service_price' => $salonId ? $salonServices[$item['service_id']]['service_price'] : $services[$item['service_id']]['price'],
                'service_duration' => $salonId ? $salonServices[$item['service_id']]['service_duration'] : $services[$item['service_id']]['duration'],
            ]);
            $models[$key]->setAttributes($item);
        }

        $this->saveItems($appointmentId, $models);

        return $models;
    }

    /**
     * @param array $models
     * @param null $attribute
     * @return bool
     * @throws AttributeValidationError
     */
    private function validateItems($models = [], $attribute = null)
    {
        foreach ($models as $model) {
            /**
             * @var AppointmentItem $model
             */
            if (!$model->validate($attribute)) throw new AttributeValidationError($model->getErrors());
        }
        return true;
    }

    /**
     * @param int $appointmentId
     * @param array $models
     * @throws AttributeValidationError
     * @throws Exception
     */
    private function saveItems(int $appointmentId, array $models): void
    {
        if ($this->validateItems($models)) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                AppointmentItem::deleteAll(['appointment_id' => $appointmentId, 'account_id' => Yii::$app->account->getId()]);

                foreach ($models as $model) $model->save(false);

                $transaction->commit();
            } catch (\Exception $exception) {
                $transaction->rollBack();

                throw $exception;
            }
        }
    }

    /**
     * @param int $appointmentId
     * @param array $data
     * @return bool
     */

    /*
     * @todo
     */
    public function deleteItems(int $appointmentId, array $data): bool
    {
        $services = AppointmentItem::find()->allById($data);

        foreach ($services as $service) $service->delete();

        return true;
    }
}