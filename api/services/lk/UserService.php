<?php

namespace api\services\lk;

use Yii;
use yii\db\Expression;
use common\models\Account;
use common\models\UserSpecialization;
use common\models\UserConvenience;
use common\models\User;
use common\models\UserProfile;
use api\services\Service;
use api\validators\UserScheduleValidator;
use api\graphql\errors\AttributeValidationError;
use api\graphql\errors\NotFoundEntryError;
use api\models\lk\UserSchedule;

/**
 * Class UserService
 *
 * @package api\services\lk
 */
class UserService extends Service
{
    /**
     * @param array $attributes
     * @return User
     * @throws \yii\db\Exception
     */
    public function create(array $attributes)
    {
        return $this->save($attributes, new User(), new UserProfile());
    }

    /**
     * @param array $attributes
     * @return User
     * @throws NotFoundEntryError
     * @throws \yii\db\Exception
     */
    public function update(array $attributes)
    {
        if (!$model = User::find()->currentUser()) throw new NotFoundEntryError();

        $profileModel = null;
        if (!empty($attributes['profile'])) {
            if (!$profileModel = UserProfile::findOne(['user_id' => $model->id])) throw new NotFoundEntryError();
        }
        return $this->save($attributes, $model, $profileModel);
    }

    /**
     * @param array $attributes
     * @param User $model
     * @param UserProfile|null $profileModel
     * @return User
     * @throws \yii\db\Exception
     */
    private function save(array $attributes, User $model, UserProfile $profileModel = null)
    {
        $model->setAttributes($attributes);

        if ($profileModel && $attributes['profile']) $profileModel->setAttributes($attributes['profile']);

        return $this->wrappedTransaction(function () use ($attributes, $model, $profileModel) {
            // Если новый пользователь, то создаем аккаунт
            if ($model->isNewRecord) {
                $account = new Account();
                $account->save(false);

                $model->account_id = $account->id;
            }

            if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

            $model->save(false);

            if ($profileModel) {
                $profileModel->user_id = $model->id;

                if (!$profileModel->validate()) throw new AttributeValidationError($profileModel->getErrors());
                $profileModel->save(false);
            }

            $this->saveSpecializations($attributes['specializations_id'] ?? []);
            $this->saveConveniences($attributes['conveniences_id'] ?? []);

            return $model;
        });
    }

    /**
     * @return bool
     * @throws NotFoundEntryError
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        if (!$model = User::find()->currentUser()) throw new NotFoundEntryError();

        return (bool)$model->delete();
    }

    /**
     * @param array $specializationsId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function createSpecializations(array $specializationsId): bool
    {
        return $this->saveSpecializations($specializationsId);
    }

    /**
     * @param array $specializationsId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function updateSpecializations(array $specializationsId)
    {
        return $this->saveSpecializations($specializationsId);
    }

    /**
     * @param array $specializationsId
     * @return bool
     * @throws \yii\db\Exception
     */
    protected function saveSpecializations(array $specializationsId)
    {
        if (!$specializationsId) return false;

        UserSpecialization::deleteAll(['user_id' => $this->getUserId()]);

        $batch = [];
        foreach ($specializationsId as $specializationId) {
            $batch[] = [
                'user_id' => $this->getUserId(),
                'specialization_id' => $specializationId
            ];
        }
        return (bool)Yii::$app->db->createCommand()->batchInsert(UserSpecialization::tableName(), [
            'user_id', 'specialization_id'
        ], $batch)->execute();
    }

    /**
     * @param array $specializationsId
     * @return bool
     * @throws NotFoundEntryError
     * @throws \yii\db\Exception
     */
    public function deleteSpecializations(array $specializationsId = [])
    {
        if (!$specializationsId) {
            $result = UserSpecialization::deleteAll(['user_id' => $this->getUserId()]);
        } else {
            $result = Yii::$app->db->createCommand()->delete(UserSpecialization::tableName(), new Expression(
                    "FIND_IN_SET(`specialization_id`, :specializationsId) AND `user_id` = :userId",
                    [
                        ':specializationsId' => implode(',', $specializationsId),
                        ':userId' => $this->getUserId()
                    ])
            )->execute();
        }
        if ($result == 0) throw new NotFoundEntryError();

        return (bool)$result;
    }

    /**
     * @param array $conveniencesId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function createConveniences(array $conveniencesId = [])
    {
        return $this->saveConveniences($conveniencesId);
    }

    /**
     * @param array $conveniencesId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function updateConveniences(array $conveniencesId = [])
    {
        return $this->saveConveniences($conveniencesId);
    }

    /**
     * @param array $conveniencesId
     * @return bool
     * @throws \yii\db\Exception
     */
    protected function saveConveniences(array $conveniencesId): bool
    {
        if (!$conveniencesId) return false;

        UserConvenience::deleteAll(['user_id' => $this->getUserId()]);

        $batch = [];
        foreach ($conveniencesId as $convenienceId) {
            $batch[] = [
                'user_id' => $this->getUserId(),
                'convenience_id' => $convenienceId
            ];
        }
        return (bool)Yii::$app->db->createCommand()->batchInsert(UserConvenience::tableName(), [
            'user_id', 'convenience_id'
        ], $batch)->execute();
    }

    /**
     * @param array $conveniencesId
     * @return bool
     * @throws NotFoundEntryError
     * @throws \yii\db\Exception
     */
    public function deleteConveniences(array $conveniencesId = [])
    {
        if (!$conveniencesId) {
            $result = UserConvenience::deleteAll(['user_id' => $this->getUserId()]);
        } else {
            $result = Yii::$app->db->createCommand()->delete(UserConvenience::tableName(), new Expression(
                    "FIND_IN_SET(`convenience_id`, :conveniencesId) AND `user_id` = :userId",
                    [
                        ':conveniencesId' => implode(',', $conveniencesId),
                        ':userId' => $this->getUserId()
                    ])
            )->execute();
        }
        if ($result == 0) throw new NotFoundEntryError();

        return (bool)$result;
    }

    /**
     * @param array $attributes
     * @return array|null|\yii\db\ActiveRecord
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function updateProfile(array $attributes)
    {
        if (!$model = UserProfile::find()->oneByCurrentUserId()) throw new NotFoundEntryError();

        $model->setAttributes($attributes);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);

        return $model;
    }

    /**
     * @param array $attributes
     * @return UserSchedule
     * @throws AttributeValidationError
     */
    public function createUserSchedule(array $attributes)
    {
        return $this->saveUserSchedule(new UserSchedule(), $attributes);
    }

    /**
     * @param array $items
     * @return null
     * @throws \yii\db\Exception
     */
    public function createUserSchedules(array $items)
    {
        return $this->wrappedTransaction(function () use ($items) {
            $attributes = ['user_id', 'type', 'start_date', 'end_date'];
            $batch = [];
            $models = [];

            foreach ($items as $key => $item) {
                $models[$key] = new UserSchedule($item);
                $models[$key]->setScenario(UserSchedule::SCENARIO_BATCH);

                if (!$models[$key]->validate()) throw new AttributeValidationError($models[$key]->getErrors());
                $batch[] = $models[$key]->getAttributes($attributes);
            }

            // Удаляем записи если даты для сохранения совподают по дням
            if ($repeatUserSchedulesDate = (new UserScheduleValidator())->getBadDate($batch)) {
                $this->deleteMasterSchedules(array_keys($repeatUserSchedulesDate));
            }

            return (bool)Yii::$app->db->createCommand()->batchInsert(UserSchedule::tableName(), $attributes, $batch)->execute();
        });
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return UserSchedule
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function updateUserSchedule(int $id, array $attributes)
    {
        $model = UserSchedule::find()
            ->byCurrentAccountId()
            ->oneById($id);

        if (!$model) throw new NotFoundEntryError();

        return $this->saveUserSchedule($model, $attributes);
    }

    /**
     * @param UserSchedule $model
     * @param array $attributes
     * @return UserSchedule
     * @throws AttributeValidationError
     */
    private function saveUserSchedule(UserSchedule $model, array $attributes)
    {
        $model->setAttributes($attributes);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        return $model;
    }

    /**
     * @param int $id
     * @return bool
     * @throws NotFoundEntryError
     */
    public function deleteUserSchedule(int $id)
    {
        return (bool) UserSchedule::deleteById($id);
    }

    /**
     * @param array $id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function deleteMasterSchedules(array $id): bool
    {
        /*
         * @todo
         *  Проверить id на injectSQL
         */
        return (bool)Yii::$app->db->createCommand()->delete(UserSchedule::tableName(), new Expression(
                "FIND_IN_SET(`id`, :id) AND `user_id` = :userId",
                [
                    ':userId' => Yii::$app->user->getId(),
                    ':id' => implode(',', $id),
                ])
        )->execute();
    }
}