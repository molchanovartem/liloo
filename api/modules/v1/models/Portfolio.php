<?php

namespace api\modules\v1\models;

use api\modules\v1\queries\PortfolioQuery;

/**
 * Class Portfolio
 * @package api\modules\v1\models
 */
class Portfolio extends \common\models\Portfolio
{
    /**
     * @return PortfolioQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new PortfolioQuery(get_called_class());
    }
}