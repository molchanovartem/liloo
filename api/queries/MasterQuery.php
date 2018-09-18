<?php

namespace api\queries;

use yii\db\ActiveQuery;
use api\queries\traits\AccountQueryTrait;

/**
 * Class MasterQuery
 *
 * @package api\queries
 */
class MasterQuery extends ActiveQuery
{
    use AccountQueryTrait;
}
