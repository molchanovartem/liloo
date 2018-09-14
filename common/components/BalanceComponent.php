<?php

namespace common\components;

use common\models\Account;
use common\models\BalanceJournal;
use Yii;
use yii\base\Component;
use yii\db\Query;

/**
 * Class BalanceComponent
 * @package common\components
 */
class BalanceComponent extends Component
{
    /**
     * @param $accountId
     * @param $sum
     * @param $typeReason
     * @param $dataReason
     * @return bool
     * @throws \Exception
     */
    public function increase($accountId, $sum, $typeReason, $dataReason): bool
    {
        return $this->execute($accountId, $sum, BalanceJournal::TYPE_OPERATION_INCREASE, $typeReason, $dataReason);
    }

    /**
     * @param $accountId
     * @param $sum
     * @param $typeReason
     * @param $dataReason
     * @return bool
     * @throws \Exception
     */
    public function decrease($accountId, $sum, $typeReason, $dataReason): bool
    {
        return $this->execute($accountId, $sum, BalanceJournal::TYPE_OPERATION_DECREASE, $typeReason, $dataReason);
    }

    /**
     * @param $accountId
     * @param $sum
     * @param $typeOperation
     * @param $typeReason
     * @param $dataReason
     * @return bool
     * @throws \yii\db\Exception
     */
    public function execute($accountId, $sum, $typeOperation, $typeReason, $dataReason): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $currentBalance = $this->getAccountBalance($accountId);
            $this->executeDB($accountId, $sum, $typeOperation);
            $this->writeJournal($accountId, $sum, $currentBalance, $typeOperation, $typeReason, $dataReason);
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }

        return true;
    }

    /**
     * @param $accountId
     * @return mixed
     */
    private function getAccountBalance($accountId)
    {
        return (new Query())->select('balance')->from('{{%account}}')->where(['id' => $accountId])->one()['balance'];
    }

    /**
     * @param $accountId
     * @param $sum
     * @param $typeOperation
     * @return bool
     * @throws \yii\db\Exception
     */
    protected function executeDB($accountId, $sum, $typeOperation): bool
    {
        $sql = '';
        if ($typeOperation == BalanceJournal::TYPE_OPERATION_INCREASE) {
            $sql = 'UPDATE ' . Account::tableName() . ' SET `balance` = `balance` + :sum WHERE `id` = :accountId';
        } elseif ($typeOperation == BalanceJournal::TYPE_OPERATION_DECREASE) {
            $sql = 'UPDATE ' . Account::tableName() . ' SET `balance` = `balance` - :sum WHERE `id` = :accountId';
        }

        return Yii::$app->db->createCommand($sql)
            ->bindParam(':sum', $sum)
            ->bindParam(':accountId', $accountId)
            ->execute();
    }

    /**
     * @param int $accountId
     * @param $sum
     * @param $currentBalance
     * @param int $typeOperation
     * @param int $typeReason
     * @param $dataReason
     */
    protected function writeJournal(int $accountId, $sum, $currentBalance, int $typeOperation, int $typeReason, $dataReason)
    {
        $balanceJournal = new BalanceJournal();

        $balanceJournal->account_id = $accountId;
        $balanceJournal->sum = $sum;
        $balanceJournal->start_sum = $currentBalance;
        $typeOperation == BalanceJournal::TYPE_OPERATION_DECREASE ? $end_sum = $currentBalance - $sum : $end_sum = $currentBalance + $sum;
        $balanceJournal->end_sum = $end_sum;
        $balanceJournal->type_operation = $typeOperation;
        $balanceJournal->type_reason = $typeReason;
        $balanceJournal->data_reason = $dataReason;

        $balanceJournal->save();
    }
}
