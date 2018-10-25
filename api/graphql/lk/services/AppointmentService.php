<?php

namespace api\graphql\lk\services;

use GraphQL\Error\Error;
use Yii;
use yii\db\Exception;
use common\models\Client;
use api\graphql\core\errors\NotFoundEntryError;
use api\models\lk\Appointment;
use api\models\lk\AppointmentItem;

/**
 * Class AppointmentService
 *
 * @package api\graphql\lk\services
 */
class AppointmentService extends \api\graphql\common\services\AppointmentService
{
    /**
     * @param array $attributes
     * @return \common\models\Appointment|null
     * @throws \Exception
     */
    public function create(array $attributes)
    {
        return $this->save(new Appointment(), $attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return null
     * @throws Error
     * @throws Exception
     * @throws NotFoundEntryError
     */
    public function update(int $id, array $attributes)
    {
        $model = $this->getAppointmentModel($id);
        if ($model->status === Appointment::STATUS_COMPLETED) throw new Error('Can not update appointment');

        return $this->wrappedTransaction(function () use ($model, $attributes) {
            AppointmentItem::deleteAll([
                'appointment_id' => $model->id,
                'account_id' => $model->account_id
            ]);

            return $this->save($model, $attributes);
        });
    }

    /**
     * @param \common\models\Appointment $model
     * @param array $attributes
     * @return \common\models\Appointment|null
     * @throws \Exception
     */
    protected function save($model, array $attributes)
    {
        /*
         * @todo
         * Не нравится, какой-то говнокод, отрефакторить
         */
        $model = parent::save($model, $attributes);

        if ($model && $model->status !== Appointment::STATUS_NEW && $model->status !== Appointment::STATUS_CONFIRMED) {
            $this->wrappedTransaction(function () use ($model, $attributes) {
                if ($model->status == Appointment::STATUS_CANCELED || $model->status == Appointment::STATUS_NOT_COME) {
                    $model->delete();
                }

                if ($model->status == Appointment::STATUS_COMPLETED) {
                    $total = 0;
                    $items = AppointmentItem::find()
                        ->byAppointmentId($model->id)
                        ->allByCurrentAccountId();

                    foreach ($items as $item) {
                        $total += $item->sum;
                    }

                    $sql = 'UPDATE ' . Client::tableName() .
                        ' SET `total_appointment` = `total_appointment` + 1, `total_spent_money` = `total_spent_money` + :total, `date_last_appointment` = :date' .
                        ' WHERE `id` = :clientId';

                    $data = date('Y-m-d', strtotime($model->start_date));
                    $clientId = $model->client_id;

                    Yii::$app->db->createCommand($sql)
                        ->bindParam(':total', $total)
                        ->bindParam(':date', $data)
                        ->bindParam(':clientId', $clientId)
                        ->execute();
                } else if ($model->status == Appointment::STATUS_NOT_COME) {
                    $sql = 'UPDATE ' . Client::tableName() . ' SET `total_failure_appointment` = `total_failure_appointment` + 1 WHERE `id` = :clientId';

                    $clientId = $model->client_id;

                    Yii::$app->db->createCommand($sql)
                        ->bindParam(':clientId', $clientId)
                        ->execute();
                }
            });
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
}