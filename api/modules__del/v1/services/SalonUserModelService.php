<?php

namespace app\modules\api\services\v1;

use Yii;
use yii\db\Exception;
use app\core\models\Account;
use app\core\models\SalonUser;
use app\core\models\User;
use app\modules\api\forms\v1\UserForm;

/**
 * Class SalonUserModelService
 * @package app\modules\api\services\v1
 */
class SalonUserModelService extends ModelService
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @param array $arguments
     */
    public function getItem($arguments = [])
    {
        $query = SalonUser::find()
            ->where(['id' => $arguments['id']])
            ->isAccount();

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }
        $this->setData(['item' => $query->one()]);
    }

    /**
     * @param array $arguments
     */
    public function getItems($arguments = [])
    {
        $query = SalonUser::find()
            ->with(['user'])
            ->where(['salon_id' => $arguments['salonId']])
            ->isAccount();

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }
        $this->setData(['items' => $query->all()]);
    }

    /**
     * @param $salonId
     * @return bool
     * @throws Exception
     */
    public function create($salonId)
    {
        return $this->save(self::SCENARIO_CREATE, ['salonId' => $salonId]);
    }

    /**
     * @param $userId
     * @return bool
     * @throws Exception
     */
    public function update($id)
    {
        return $this->save(self::SCENARIO_UPDATE, [], ['id' => $id]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return SalonUser::deleteAll(['id' => $id, 'account_id' => $this->getAccountId()]);
    }

    /**
     * @param $scenario
     * @param array $params
     * @param array $conditions
     * @return bool
     * @throws Exception
     */
    private function save($scenario, $params = [], $conditions = []): bool
    {
        /*
         * @todo
         */
        $form = new UserForm([
            'type' => User::TYPE_MASTER,
            'password' => 'sdafsaf'
        ]);
        $form->load($this->getData('post'));

        /**
         *      * Валидация салона на существование в данном акаунте
         */
        /*
         * @todo
         * Валидация салона на существование в данном акаунте
         */

        if ($result = $form->validate(['type', 'login', 'password'])) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Создание
                if ($scenario === self::SCENARIO_CREATE) {
                    // Создаем аккаунт
                    Yii::$app->db->createCommand()->insert(Account::tableName(), [])
                        ->execute();

                    $accountId = Yii::$app->db->getLastInsertID();
                    $form->account_id = $accountId;

                    // Создаем пользователя
                    Yii::$app->db->createCommand()->insert(User::tableName(), $form->getAttributes())
                        ->execute();

                    // Создаем связь: салон-пользователь
                    Yii::$app->db->createCommand()->insert(SalonUser::tableName(), [
                        'account_id' => $this->getAccountId(),
                        'salon_id' => $params['salonId'],
                        'user_id' => Yii::$app->db->getLastInsertID()
                    ])->execute();

                } else if ($scenario === self::SCENARIO_UPDATE) { // Обновление
                    Yii::$app->db->createCommand()->update(User::tableName(), $form->getAttributes(), $conditions)
                        ->execute();
                }

                $transaction->commit();
            } catch (Exception $exception) {
                $transaction->rollBack();
                throw $exception;
            }
        }
        $this->readModelErrors($form);
        return $result;
    }
}