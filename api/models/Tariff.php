<?php

namespace api\models;

use api\queries\TariffQuery;

/**
 * Class Tariff
 * @package api\models
 */
class Tariff extends \common\models\Tariff
{
    /**
     * @return TariffQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new TariffQuery(get_called_class());
    }
}