<?php

namespace api\queries;

use api\queries\traits\AccountQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class AccountTariffQuery
 *
 * @package api\queries
 */
class AccountTariffQuery extends ActiveQuery
{
    use AccountQueryTrait;
}
