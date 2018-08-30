<?php

namespace api\repositories;

use api\models\Appointment;
use api\models\AppointmentItem;

/**
 * Class AppointmentRepository
 * @package api\repositories
 */
class AppointmentRepository extends Repository
{
    /**
     * @var null
     */
    protected static $instance = null;

    public $items = [];

    /**
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getAll($startDate, $endDate): array
    {
        /*
         * @todo
         * Реализовать выборку по дате
         * Сортировку
         */

        return Appointment::find()
            ->isAccount()
            ->indexBy('id')
            ->all();
    }

    /**
     * @param int $id
     * @return \api\queries\Query|\yii\db\ActiveQuery
     */
    public function findById(int $id)
    {
        return Appointment::find()
            ->byId($id)
            ->isAccount();
    }

    /**
     * @param int $appointmentId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getItems(int $appointmentId)
    {
        return AppointmentItem::find()
            ->where(['appointment_id' => $appointmentId])
            ->isAccount()
            ->all();
    }
}