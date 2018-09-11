<?php
/**
 * Created by PhpStorm.
 * User: belimov
 * Date: 09.07.17
 * Time: 12:35
 */

namespace app\components\balance;


use Yii;
use yii\base\Component;
use yii\web\HttpException;

/**
 * Class Balance
 * @package app\components\balance
 */
abstract class Balance extends Component
{
    const TYPE_OPERATION_INCREASE = 1;
    const TYPE_OPERATION_DECREASE = 2;

    const TYPE_SERVICE = 'service';
    const TYPE_NORMAL = 'normal';
    /**
     * @var string
     */
    public $balanceTableName;

    // убрать после миграции
    public $createTime;

    protected abstract function increase($userId, $sum, $params = []): bool;

    protected abstract function decrease($userId, $sum, $params = []): bool;

    protected abstract function writeJournal($params = []): bool;

    public function init()
    {
        if (!$this->balanceTableName) {
            throw new HttpException(500, 'No table');
        }
        parent::init();
    }

    public function increaseSumRate($userId, $sum, $rateValue, $params = [], $type = self::TYPE_SERVICE)
    {
        return $this->increase(
            $userId,
            $this->getCalculatedSumRate($sum, $rateValue, $type),
            ['reason' => $this->getInfoCommission($params['reason'])]
        );
    }

    public function increaseWithRate($userId, $sum, $rateValue, $params = [], $type = self::TYPE_SERVICE)
    {
        $this->increase($userId, $sum, $params);
        $this->increaseSumRate($userId, $sum, $rateValue, $params, $type);
        return false;
    }

    public function decreaseSumRate($userId, $sum, $rateValue, $params = [], $type = self::TYPE_SERVICE)
    {
        return $this->decrease(
            $userId,
            $this->getCalculatedSumRate($sum, $rateValue, $type),
            ['reason' => $this->getInfoCommission($params['reason'])]
        );
    }

    public function decreaseWithRate($userId, $sum, $rateValue, $params = [], $type = self::TYPE_SERVICE)
    {
        $this->decrease($userId, $sum, $params);
        $this->decreaseSumRate($userId, $sum, $rateValue, $params, $type);
        return false;
    }

    protected function getCalculatedSumRate($sum, $rateValue, $type)
    {
        switch ($type) {
            case $type === self::TYPE_SERVICE :
                return ($sum / ((100 - $rateValue) / 100)) - $sum;
                break;
            case $type === self::TYPE_NORMAL :
                return ($sum * $rateValue) / 100;
                break;
            default :
                return 0;
        }
    }

    protected function getInfoCommission($reason): string
    {
        return Yii::t('app', '{reason} - commission', ['reason' => $reason]);
    }

    protected function getJournalBalanceTableName()
    {
        return JournalBalanceModel::tableName();
    }
}