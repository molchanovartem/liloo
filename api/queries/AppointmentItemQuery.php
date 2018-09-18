<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;

/**
 * Class AppointmentItemQuery
 *
 * @package api\queries
 */
class AppointmentItemQuery extends ActiveQuery
{
    use AccountQueryTrait;

    /**
     * @param array $id
     * @return mixed
     */
    public function allById(array $id)
    {
        return $this->byId($id)
            ->allByCurrentAccountId();
    }
}
