<?php

namespace api\modules\v1\services;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use common\models\UserService;
use common\models\Convenience;
use common\models\Specialization;
use api\modules\v1\models\Service;
use api\modules\v1\models\User;
use api\modules\v1\models\Salon;
use api\modules\v1\models\SalonUser;
use api\modules\v1\models\SalonConvenience;
use api\modules\v1\models\SalonSpecialization;

/**
 * Class SalonModelService
 * @package app\modules\api\services\v1
 */
class SalonModelService extends ModelService
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function index()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Salon::find()
                ->isAccount()
        ]);

        $this->setResult($dataProvider);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function view(int $id): bool
    {
        $model = Salon::find()
            ->where(['id' => $id])
            ->isAccount()
            ->one();

        $this->addData(['model' => $model]);
        $this->setResult($model);

        return (bool)$model;
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function create(): bool
    {
        //return $this->save(self::SCENARIO_CREATE);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function update(int $id): bool
    {
        //return $this->save(self::SCENARIO_UPDATE, ['id' => $id, 'account_id' => $this->getAccountId()]);
    }

    /**
     * @param $scenario
     * @param array $conditions
     * @return bool
     * @throws Exception
     */
    /*
    private function save($scenario, $conditions = []): bool
    {
        $form = new SalonForm();
        $form->load($this->getData('post'));

        if ($result = $form->validate()) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $attributes = $form->getAttributes(null, ['specializations', 'conveniences']);
                $id = null;

                if ($scenario === self::SCENARIO_CREATE) {
                    Yii::$app->db->createCommand()->insert(Salon::tableName(), $attributes)
                        ->execute();

                    $id = Yii::$app->db->getLastInsertID();
                } else if ($scenario === self::SCENARIO_UPDATE) {
                    Yii::$app->db->createCommand()->update(Salon::tableName(), $attributes, $conditions)
                        ->execute();
                    $id = $conditions['id'];
                }

                if ($id) {
                    $this->saveSpecializations($id, (array)$form->specializations);
                    $this->saveConveniences($id, (array)$form->conveniences);
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
    */

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Salon::deleteAll(['id' => $id]);
    }

    /**
     * @param int $salonId
     */
    public function indexUsers(int $salonId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()
                ->alias('user')
                ->where(['salonUser.salon_id' => $salonId])
                ->with(['profile'])
                ->leftJoin(SalonUser::tableName() . ' salonUser', '`salonUser`.`user_id` = `user`.`id`')
        ]);

        $this->setResult($dataProvider);
    }

    /**
     * @param $salonId
     * @return bool
     */
    public function addUsers(int $salonId): bool
    {
        return $this->saveSalonUsers($salonId, $this->getData('bodyParams', []));
    }

    /**
     * @param $salonId
     * @return bool
     */
    public function updateUsers(int $salonId): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            SalonUser::deleteAll(['salon_id' => $salonId]);
            $this->saveSalonUsers($salonId, $this->getData('bodyParams', []));

            $transaction->commit();

            return true;
        } catch (Exception $exception) {
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * @param $salonId
     * @param array $users
     * @return bool
     */
    private function saveSalonUsers($salonId, $users = []): bool
    {
        $batch = [];
        foreach ($users as $userId) {
            $batch[] = [
                'account_id' => $this->getAccountId(),
                'salon_id' => $salonId,
                'user_id' => $userId
            ];
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(SalonUser::tableName(), [
                'account_id', 'salon_id', 'user_id'
            ], $batch)->execute();
        }
        return (bool)$batch;
    }

    /**
     * @param int $salonId
     * @param null $userId
     * @return bool
     */
    public function deleteUsers(int $salonId, $userId = null): bool
    {
        $conditions = ['salon_id' => $salonId];

        if ($userId) {
            $conditions['user_id'] = $userId;
        }

        return (bool)SalonUser::deleteAll($conditions);
    }


    /**
     * @param int $salonId
     * @param int $userId
     */
    public function indexUserServices(int $salonId, int $userId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Service::find()
                ->alias('service')
                ->where(['salonUserService.salon_id' => $salonId])
                ->andWhere(['salonUserService.user_id' => $userId])
                ->leftJoin(UserService::tableName() . ' salonUserService', '`salonUserService`.`service_id` = `service`.`id`')
        ]);

        $this->setResult($dataProvider);
    }

    /**
     * @param int $salonId
     * @param int $userId
     * @return bool
     */
    public function addUserServices(int $salonId, int $userId): bool
    {
        return $this->saveSalonUserServices($salonId, $userId, $this->getData('bodyParams', []));
    }

    /**
     * @param $salonId
     * @return bool
     */
    public function updateUserServices(int $salonId, int $userId): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            UserService::deleteAll(['salon_id' => $salonId, 'user_id' => $userId]);
            $this->saveSalonUserServices($salonId, $userId, $this->getData('bodyParams', []));

            $transaction->commit();

            return true;
        } catch (Exception $exception) {
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * @param $salonId
     * @param $userId
     * @param array $services
     * @return bool
     */
    private function saveSalonUserServices($salonId, $userId, $services = []): bool
    {
        $batch = [];
        foreach ($services as $serviceId) {
            $batch[] = [
                'account_id' => $this->getAccountId(),
                'salon_id' => $salonId,
                'user_id' => $userId,
                'service_id' => $serviceId
            ];
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(UserService::tableName(), [
                'account_id', 'salon_id', 'user_id', 'service_id'
            ], $batch)->execute();
        }
        return (bool)$batch;
    }

    /**
     * @param int $salonId
     * @param int $userId
     * @param null $serviceId
     * @return bool
     */
    public function deleteUserServices(int $salonId, int $userId, $serviceId = null): bool
    {
        $conditions = [
            'salon_id' => $salonId,
            'user_id' => $userId
        ];

        if ($serviceId) {
            $conditions['service_id'] = $serviceId;
        }

        return (bool)UserService::deleteAll($conditions);
    }


    public function indexSpecializations($salonId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Specialization::find()
                ->alias('sp')
                ->leftJoin(SalonSpecialization::tableName() . ' ss', '`sp`.`id` = `ss`.`specialization_id`')
                ->where(['ss.salon_id' => $salonId])
        ]);

        $this->setResult($dataProvider);
    }

    /**
     * @param int $salonId
     * @return bool
     */
    public function addSpecializations(int $salonId): bool
    {
        return $this->saveSpecializations($salonId, $this->getData('bodyParams', []));
    }

    /**
     * @param int $salonId
     * @return bool
     */
    public function updateSpecializations(int $salonId): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            SalonSpecialization::deleteAll(['salon_id' => $salonId]);
            $this->saveSpecializations($salonId, $this->getData('bodyParams', []));

            $transaction->commit();

            return true;
        } catch (Exception $exception) {
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * @param int $salonId
     * @param array $specializations
     * @return bool
     */
    private function saveSpecializations(int $salonId, array $specializations = []): bool
    {
        $batch = [];
        foreach ($specializations as $specializationId) {
            if (is_numeric($specializationId)) {
                $batch[] = [
                    'salon_id' => $salonId,
                    'specialization_id' => $specializationId
                ];
            }
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(SalonSpecialization::tableName(), [
                'salon_id', 'specialization_id'
            ], $batch)->execute();
        }
        return (bool)$batch;
    }

    /**
     * @param int $salonId
     * @param null $specializationId
     * @return bool
     */
    public function deleteSpecializations(int $salonId, $specializationId = null): bool
    {
        $conditions = ['salon_id' => $salonId];
        if ($specializationId) {
            $conditions['specialization_id'] = $specializationId;
        }

        return SalonSpecialization::deleteAll($conditions) > 0;
    }

    public function indexConveniences($salonId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Convenience::find()
                ->alias('c')
                ->leftJoin(SalonConvenience::tableName() . ' s', '`c`.`id` = `s`.`convenience_id`')
                ->where(['s.salon_id' => $salonId])
        ]);

        $this->setResult($dataProvider);
    }

    /**
     * @param int $salonId
     * @return bool
     */
    public function addConveniences(int $salonId): bool
    {
        return $this->saveConveniences($salonId, $this->getData('bodyParams', []));
    }

    /**
     * @param int $salonId
     * @return bool
     */
    public function updateConveniences(int $salonId): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            SalonConvenience::deleteAll(['salon_id' => $salonId]);
            $this->saveConveniences($salonId, $this->getData('bodyParams', []));

            $transaction->commit();

            return true;
        } catch (Exception $exception) {
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * @param int $salonId
     * @param null $conveniencesId
     * @return bool
     */
    public function deleteConveniences(int $salonId, $conveniencesId = null): bool
    {
        $conditions = ['salon_id' => $salonId];
        if ($conveniencesId) {
            $conditions['convenience_id'] = $conveniencesId;
        }

        return SalonConvenience::deleteAll($conditions) > 0;
    }

    /**
     * @param $salonId
     * @param array $conveniences
     * @return bool
     */
    private function saveConveniences($salonId, array $conveniences = [])
    {
        $batch = [];
        foreach ($conveniences as $id) {
            if (is_numeric($id)) {
                $batch[] = [
                    'salon_id' => $salonId,
                    'convenience_id' => $id
                ];
            }
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(SalonConvenience::tableName(), ['salon_id', 'convenience_id'], $batch)
                ->execute();
        }
        return (bool)$batch;
    }
}