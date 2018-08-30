<?php

namespace api\modules\v1\services;

use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use common\models\UserConvenience;
use common\models\UserSpecialization;
use api\modules\v1\models\UserProfile;
use api\modules\v1\models\User;

/**
 * Class UserModelService
 * @package api\services\v1
 */
class UserModelService extends ModelService
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function view($id)
    {
        $model = User::find()
            ->where(['id' => $id])
            ->one();

        $this->setResult($model);

        return (bool) $model;
    }

    /**
     * @return bool
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function create(): bool
    {
        return $this->save(self::SCENARIO_CREATE);
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function update(int $id): bool
    {
        return $this->save(self::SCENARIO_UPDATE, ['id' => $id, 'account_id' => $this->getAccountId()]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool) User::deleteAll(['id' => $id]);
    }

    // {"account_id": 1,"login": "ass","type": 1,"password": "5555", "profile": {"surname": "kill 123", "name": "321321321"}, "specializations": [1,2], "conveniences": [1,2]}

    /**
     * @param $scenario
     * @param array $conditions
     * @return bool
     * @throws Exception
     * @throws NotFoundHttpException
     */
    private function save($scenario, $conditions = []): bool
    {
        if ($scenario === self::SCENARIO_CREATE) {
            $model = new User();
            $modelProfile = new UserProfile();

        }  else if ($scenario === self::SCENARIO_UPDATE) {
            $model = $this->findUserModel($conditions);
            $modelProfile = $this->findUserProfileModel($model->id);
        }
        $model->account_id = $this->getAccountId();

        $model->load($this->getData('bodyParams'), '');
        $modelProfile->load($this->getData('bodyParams.profile'), '');

        if ($model->validate()) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save(false);
                $modelProfile->user_id = $model->id;

                   $this->saveSpecializations($model->id, $this->getData('bodyParams.specializations', []));
                   $this->saveConveniences($model->id,  $this->getData('bodyParams.conveniences', []));

                if ($modelProfile->validate()) {
                    $modelProfile->save(false);

                    $transaction->commit();

                    $this->setResult(array_merge(
                        $model->getAttributes(),
                        ['profile' => $modelProfile->getAttributes()]
                    ));

                    return true;
                }
            } catch (Exception $exception) {
                $transaction->rollBack();
                throw $exception;
            }
        }
        return false;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function viewProfile(int $userId): bool
    {
        $model = UserProfile::findOne(['user_id' => $userId]);

        $this->setResult($model);

        return (bool) $model;
    }

    /**
     * @param int $userId
     * @return bool
     * @throws NotFoundHttpException
     */
    public function updateProfile(int $userId): bool
    {
        $model = $this->findUserProfileModel($userId);
        $model->load($this->getData('bodyParams'), '');

        $result = $model->save();

        $this->setResult($model);

        return $result;
    }


    /**
     * @param int $userId
     * @return bool
     */
    public function addSpecializations(int $userId): bool
    {
        return $this->saveSpecializations($userId, $this->getData('bodyParams', []));
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function updateSpecializations(int $userId): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            UserSpecialization::deleteAll(['user_id' => $userId]);
            $this->saveSpecializations($userId, $this->getData('bodyParams', []));

            $transaction->commit();

            return true;
        } catch (Exception $exception) {
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * @param int $userId
     * @param null $specializationId
     * @return bool
     */
    public function deleteSpecializations(int $userId, $specializationId = null): bool
    {
        $conditions = ['user_id' => $userId];
        if ($specializationId) {
            $conditions['specialization_id'] = $specializationId;
        }

        return UserSpecialization::deleteAll($conditions) > 0;
    }

    /**
     * @param int $userId
     * @param array $specializations
     * @return bool
     */
    private function saveSpecializations(int $userId, array $specializations = []): bool
    {
        $batch = [];
        foreach ($specializations as $specializationId) {
            if (is_numeric($specializationId)) {
                $batch[] = [
                    'user_id' => $userId,
                    'specialization_id' => $specializationId
                ];
            }
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(UserSpecialization::tableName(), ['user_id', 'specialization_id'], $batch)
                ->execute();
        }
        return (bool) $batch;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function addConveniences(int $userId): bool
    {
        return $this->saveConveniences($userId, $this->getData('bodyParams', []));
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function updateConveniences(int $userId): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            UserConvenience::deleteAll(['user_id' => $userId]);
            $this->saveConveniences($userId, $this->getData('bodyParams', []));

            $transaction->commit();

            return true;
        } catch (Exception $exception) {
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * @param int $userId
     * @param null $conveniencesId
     * @return bool
     */
    public function deleteConveniences(int $userId, $conveniencesId = null): bool
    {
        $conditions = ['user_id' => $userId];
        if ($conveniencesId) {
            $conditions['convenience_id'] = $conveniencesId;
        }

        return UserConvenience::deleteAll($conditions) > 0;
    }

    /**
     * @param $userId
     * @param array $conveniences
     * @return bool
     */
    private function saveConveniences($userId, array $conveniences = [])
    {
        $batch = [];
        foreach ($conveniences as $id) {
            if (is_numeric($id)) {
                $batch[] = [
                    'user_id' => $userId,
                    'convenience_id' => $id
                ];
            }
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(UserConvenience::tableName(), ['user_id', 'convenience_id'], $batch)
                ->execute();
        }
        return (bool) $batch;
    }

    /**
     * @param int $id
     * @return User|null
     * @throws NotFoundHttpException
     */
    private function findUserModel(int $id)
    {
        if (!$result = User::findOne(['id' => $id])) {
            throw new NotFoundHttpException(); // Данное исключение сдесь быть не должно, место в контролере
        }
        return $result;
    }

    /**
     * @param int $userId
     * @return UserProfile|null
     * @throws NotFoundHttpException
     */
    private function findUserProfileModel(int $userId)
    {
        if (!$result = UserProfile::findOne(['user_id' => $userId])) {
            throw new NotFoundHttpException();
        }
        return $result;
    }
}