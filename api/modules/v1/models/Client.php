<?php

namespace api\modules\v1\models;

use api\modules\v1\queries\ClientQuery;

/**
 * Class Client
 * @package api\modules\v1\models
 */
class Client extends \common\models\Client
{
    public static function find()
    {
        return new ClientQuery(get_called_class());
    }
}