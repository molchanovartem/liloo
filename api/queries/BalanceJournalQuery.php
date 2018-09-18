<?php

namespace api\queries;

use api\queries\traits\AccountQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class BalanceJournalQuery
 *
 * @package api\queries
 */
class BalanceJournalQuery extends ActiveQuery
{
    use AccountQueryTrait;
}
