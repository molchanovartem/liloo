<?php
/**
 * Created by PhpStorm.
 * User: belimov
 * Date: 09.07.17
 * Time: 12:13
 */

namespace app\components\balance;


use Yii;

class StorehouseBalance extends Balance
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
            $this->executeDB($sum, $params, $typeOperation);
            $this->writeJournal([
                'storehouseId' => $params['storehouseId'],
                'userId' => $userId,
                'sum' => $sum,
                'typeOperation' => $typeOperation,
                'reason' => $params['reason'],
            ]);
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
        return true;
    }

    protected function executeDB($sum, $params = [], $typeOperation): bool
    {
        if (empty($params['storehouseId'])) {
            throw new \Exception('No isset storehouseId');
        }

        $sql = '';
        if ($typeOperation == self::TYPE_OPERATION_INCREASE) {
            $sql = 'UPDATE ' . $this->balanceTableName . ' SET `balance` = `balance` + :sum WHERE `id` = :storehouseId';
        } elseif ($typeOperation == self::TYPE_OPERATION_DECREASE) {
            $sql = 'UPDATE ' . $this->balanceTableName . ' SET `balance` = `balance` - :sum WHERE `id` = :storehouseId';
        }

        return Yii::$app->db->createCommand($sql)
            ->bindParam(':sum', $sum)
            ->bindParam(':storehouseId', $params['storehouseId'])
            ->execute();
    }

    protected function writeJournal($params = []): bool
    {
        if (empty($params['storehouseId'])) {
            throw new \Exception('No isset storehouseId');
        }

        return Yii::$app->db->createCommand()->insert($this->getJournalBalanceTableName(), [
            'user_id' => $params['userId'],
            'storehouse_id' => $params['storehouseId'],
            'type' => JournalBalanceModel::TYPE_STOREHOUSE,
            'type_operation' => $params['typeOperation'],
            'sum' => $params['sum'],
            'reason' => $params['reason'],
            'date_time' => $this->createTime,
        ])->execute();
    }
}