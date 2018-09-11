<?php

namespace common\components;

use common\models\Account;
use common\models\BalanceJournal;
use Yii;
use yii\base\Component;

/**
 * Class BalanceComponent
 * @package common\components
 */
class BalanceComponent extends Component
{
    public function increase($accountId, $sum, $reason): bool
    {
        return $this->execute($accountId, $sum, BalanceJournal::BALANCE_INCREASE, $reason);
    }

    public function decrease($accountId, $sum, $reason): bool
    {
        return $this->execute($accountId, $sum, BalanceJournal::BALANCE_DECREASE, $reason);
    }

    public function execute($accountId, $sum, $typeOperation, $reason): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->executeDB($accountId, $sum, $typeOperation);
            $this->writeJournal($accountId, $sum, $typeOperation, $reason);
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }

        return true;
    }

    protected function executeDB($accountId, $sum, $typeOperation): bool
    {
        $sql = '';
        if ($typeOperation == BalanceJournal::BALANCE_INCREASE) {
            $sql = 'UPDATE ' . Account::tableName() . ' SET `balance` = `balance` + :sum WHERE `id` = :accountId';
        } elseif ($typeOperation == BalanceJournal::BALANCE_DECREASE) {
            $sql = 'UPDATE ' . Account::tableName() . ' SET `balance` = `balance` - :sum WHERE `id` = :accountId';
        }

        return Yii::$app->db->createCommand($sql)
            ->bindParam(':sum', $sum)
            ->bindParam(':accountId', $accountId)
            ->execute();
    }

    protected function writeJournal(int $accountId, $sum, int $typeOperation, $reason)
    {
        $balanceJournal = new BalanceJournal();

        $balanceJournal->account_id = $accountId;
        $balanceJournal->type_operation = $typeOperation;
        $balanceJournal->sum = $sum;
        $balanceJournal->reason = $reason;

        $balanceJournal->save();
    }
}