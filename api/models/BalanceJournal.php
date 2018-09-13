<?php

namespace api\models;

use api\queries\BalanceJournalQuery;

class BalanceJournal extends \common\models\BalanceJournal
{
    /**
     * @return BalanceJournalQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new BalanceJournalQuery(get_called_class());
    }
}