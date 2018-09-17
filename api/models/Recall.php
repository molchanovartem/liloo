<?php

namespace api\models;

use api\queries\RecallQuery;

/**
 * Class Recall
 * @package api\models
 */
class Recall extends \common\models\Recall
{
    /**
     * @return RecallQuery|\common\queries\RecallQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new RecallQuery(get_called_class());
    }
}
