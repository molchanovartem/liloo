<?php

namespace api\models;

use api\queries\RecallQuery;

/**
 * @property mixed id
 */
class Recall extends \common\models\Recall
{
    public static function find()
    {
        return new RecallQuery(get_called_class());
    }
}
