<?php

namespace api\buffers;

use api\models\AppointmentItem;
use yii\helpers\ArrayHelper;

/**
 * Class AppointmentItemBuffer
 *
 * @package api\buffers
 */
class AppointmentItemBuffer extends Buffer
{
    public function allByAppointmentId(int $appointmentId)
    {
        if (!$this->data) {
            $items = AppointmentItem::find()
                ->where(['in', 'appointment_id', $this->getKeys()])
                ->byAccountId()
                ->all();

            $this->data = ArrayHelper::index($items, null, 'appointment_id');
        }
        return $this->data[$appointmentId] ?? [];
    }
}