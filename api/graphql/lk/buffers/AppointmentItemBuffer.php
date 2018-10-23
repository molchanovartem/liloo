<?php

namespace api\graphql\lk\buffers;

use yii\helpers\ArrayHelper;
use api\graphql\core\ActiveBuffer;
use api\models\lk\AppointmentItem;

/**
 * Class AppointmentItemBuffer
 *
 * @package api\graphql\lk\buffers
 */
class AppointmentItemBuffer extends ActiveBuffer
{
    public function allByAppointmentId(int $appointmentId)
    {
        if (!$this->data) {
            $items = AppointmentItem::find()
                ->where(['in', 'appointment_id', $this->getKeys()])
                ->allByCurrentAccountId();

            $this->data = ArrayHelper::index($items, null, 'appointment_id');
        }
        return $this->data[$appointmentId] ?? [];
    }
}