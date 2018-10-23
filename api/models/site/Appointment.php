<?php

namespace api\models\site;

/**
 * Class Appointment
 *
 * @package api\models\site
 */
class Appointment extends \common\models\Appointment
{
    const SCENARIO_MASTER = 'master';
    const SCENARIO_SALON = 'salon';

    /**
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['user_id'], 'required', 'on' => self::SCENARIO_MASTER],
            [['salon_id', 'master_id'], 'required', 'on' => self::SCENARIO_SALON],
        ]);
    }
}