<?php

namespace admin\forms;

use common\components\tariffAccess\rules\MasterRule;
use yii\base\Model;

/**
 * Class TariffForm
 * @package admin\forms
 */
class TariffForm extends Model
{
    public $access;

    /**
     * @return array
     */
    public function getTariffAccessList()
    {
        return [
            MasterRule::RULE_MASTER_CREATE => 'Создание мастера',
            MasterRule::RULE_MASTER_UPDATE => 'Обновление мастера',
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'access' => 'Доступы',
        ];
    }
}