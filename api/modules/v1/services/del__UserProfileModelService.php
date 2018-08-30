<?php

namespace app\modules\api\services\v1;

use Yii;
use yii\db\Exception;
use app\core\models\UserConvenience;
use app\core\models\UserSpecialization;
use app\core\models\UserProfile;
use app\core\exceptions\NoModelException;
use app\modules\api\forms\v1\UserProfileForm;

/**
 * Class UserProfileModelService
 * @package app\modules\api\services\v1
 */
class delUserProfileModelService extends ModelService
{
    /**
     * @param array $arguments
     * @throws NoModelException
     */
    public function getItem($arguments = [])
    {
        $query = UserProfile::find()
            ->with(['specializations', 'conveniences'])
            ->where(['user_id' => Yii::$app->user->getId()]);

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }

        if (!$item = $query->one()) {
            throw new NoModelException();
        }

        $this->setData([
            'item' => $item
        ]);
    }

    /**
     * @param array $arguments
     */
    public function getItems($arguments = [])
    {
        $this->setData(['items' => []]);
    }

    /**
     * @param $id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function update($id): bool
    {
        return $this->save(['user_id' => Yii::$app->user->getId()]);
    }

    /**
     * @param $scenario
     * @param array $conditions
     * @return bool
     * @throws Exception
     */
    private function save(array $conditions = [])
    {
        $form = new UserProfileForm();
        $form->load($this->getData('post'));

        if ($result = $form->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = UserProfile::find()
                    ->where(['user_id' => Yii::$app->user->getId()])
                    ->one();
                $model->setAttributes($form->getAttributes());
                $model->save();

                $this->saveSpecializations($form->user_id, (array)$form->specializations);
                $this->saveConveniences($form->user_id, (array)$form->conveniences);

                $transaction->commit();
            } catch (Exception $exception) {
                $transaction->rollBack();

                throw $exception;
            }
        }
        $this->readModelErrors($form);
        return $result;
    }

    /**
     * @param $userId
     * @param array $specializations
     * @throws \yii\db\Exception
     */
    private function saveSpecializations($userId, array $specializations = [])
    {
        UserSpecialization::deleteAll(['user_id' => $userId]);

        $batch = [];
        foreach ($specializations as $specializationId) {
            $batch[] = [
                'user_id' => $userId,
                'specialization_id' => $specializationId
            ];
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(UserSpecialization::tableName(), ['user_id', 'specialization_id'], $batch)
                ->execute();
        }
    }

    /**
     * @param $userId
     * @param array $conveniences
     * @throws Exception
     */
    private function saveConveniences($userId, array $conveniences = [])
    {
        UserConvenience::deleteAll(['user_id' => $userId]);

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
    }
}