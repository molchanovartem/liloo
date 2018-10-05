<?php

namespace site\services;

use site\models\Appointment;
use common\core\service\ModelService;

/**
 * Class AppointmentService
 *
 * @package site\services
 */
class AppointmentService extends ModelService
{
    /**
     * @return bool
     */
    public function save()
    {
        $model = new Appointment();
        $this->setData([
            'model' => $model
        ]);

        return $model->load($this->getData('post')) && $model->save();
    }
}