<?php

namespace app\modules\api\services\v1;

use Yii;
use app\core\models\UserService;

/**
 * Class SalonUserServiceModelService
 * @package app\modules\api\services\v1
 */
class SalonUserServiceModelService extends ModelService
{
    public function getItem($arguments = [])
    {
        // TODO: Implement getItem() method.
    }

    public function getItems($arguments = [])
    {
        $query = UserService::find()
            ->with(['user', 'service'])
            ->where(['user_id' => $arguments['userId']])
            ->isAccount();

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }

        return $query->all();
    }

    public function save($salonId, $userId)
    {
        // Удаляем связи
        UserService::deleteAll(['user_id' => $userId, 'account_id' => $this->getAccountId()]);

        // Валидируем
        // Сохраняем
        $batch = [];
        foreach ((array)$this->getData('post', 'Service') as $serviceId) {
            $batch[] = [
                'account_id' => $this->getAccountId(),
                'salon_id' => $salonId,
                'user_id' => $userId,
                'service_id' => $serviceId
            ];
        }

        Yii::$app->db->createCommand()->batchInsert(UserService::tableName(), [
            'account_id', 'salon_id', 'user_id', 'service_id'
        ], $batch)->execute();

        return true;
    }
}