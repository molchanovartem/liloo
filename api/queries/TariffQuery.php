<?php

namespace api\queries;

use yii\db\ActiveQuery;
use common\queries\CommonQueryTrait;

/**
 * Class TariffQuery
 *
 * @package api\queries
 */
class TariffQuery extends ActiveQuery
{
    use CommonQueryTrait;

    /**
     * @param null $status
     * @return array|\yii\db\ActiveRecord[]
     */
    public function allByParams($status = null)
    {
        return $this->andFilterWhere(['status' => $status])
            ->all();
    }
}
