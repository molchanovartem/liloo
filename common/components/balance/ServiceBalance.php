<?php
/**
 * Created by PhpStorm.
 * User: belimov
 * Date: 09.07.17
 * Time: 12:13
 */

namespace app\components\balance;


use Yii;

class ServiceBalance extends Balance
{
    public function increase($userId, $sum, $params = []): bool
    {
        return $this->execute($userId, $sum, $params, self::TYPE_OPERATION_INCREASE);
    }

    public function decrease($userId, $sum, $params = []): bool
    {
        return $this->execute($userId, $sum, $params, self::TYPE_OPERATION_DECREASE);
    }

    public function execute($userId, $sum, $params = [], $typeOperation): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->executeDB($sum, $typeOperation);
            $this->writeJournal([
                'userId' => $userId,
                'typeOperation' => $typeOperation,
                'sum' => $sum,
                'reason' => $params['reason'],
            ]);
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
        return true;
    }

    protected function executeDB($sum, $typeOperation): bool
    {
        $sql = '';
        if ($typeOperation == self::TYPE_OPERATION_INCREASE) {
            $sql = 'UPDATE ' . $this->balanceTableName . ' SET `balance` = `balance` + :sum';
        } elseif ($typeOperation == self::TYPE_OPERATION_DECREASE) {
            $sql = 'UPDATE ' . $this->balanceTableName . ' SET `balance` = `balance` - :sum';
        }

        return Yii::$app->db->createCommand($sql)
            ->bindParam(':sum', $sum)
            ->execute();
    }

    protected function writeJournal($params = []): bool
    {
        return Yii::$app->db->createCommand()->insert($this->getJournalBalanceTableName(), [
            'user_id' => $params['userId'],
            'type' => JournalBalanceModel::TYPE_SERVICE,
            'type_operation' => $params['typeOperation'],
            'sum' => $params['sum'],
            'reason' => $params['reason'],
            'date_time' => $this->createTime,
        ])->execute();
    }
}