<?php

namespace api\modules\v1\models;

use api\modules\v1\queries\ServiceQuery;

/**
 * Class Service
 * @package api\modules\v1\models
 */
class Service extends \common\models\Service
{
    /**
     * @return ServiceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }
}