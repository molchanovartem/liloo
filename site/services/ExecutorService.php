<?php

namespace site\services;

use common\models\MasterSchedule;
use common\models\Recall;
use common\models\Salon;
use common\models\SalonService;
use common\models\SalonSpecialization;
use common\models\Service;
use common\models\Specialization;
use common\models\User;
use common\models\UserProfile;
use common\models\UserSchedule;
use common\models\UserSpecialization;
use site\forms\FilterForm;

/**
 * Class ExecutorService
 * @package site\services
 */
class ExecutorService extends \api\services\site\ExecutorService
{
    private $specializationService = [];

    public function index()
    {
        $form = new FilterForm();
        $form->load($this->getData('get'));

        $queryUsers = User::find()
            ->select(['u.*', 'up.name', 'up.surname', 'up.address', 'up.city_id', 'up.latitude', 'up.longitude'])
            ->alias('u')
            ->leftJoin(UserSpecialization::tableName() . ' us', '`u`.`id` = `us`.`user_id`')
            ->leftJoin(Service::tableName() . ' ser', 'ser.account_id = u.account_id')
            ->leftJoin(UserProfile::tableName() . ' up', '`u`.`id` = `up`.`user_id`')
            ->leftJoin(UserSchedule::tableName() . ' usch', '`u`.`id` = `usch`.`user_id`');

        $querySalons = Salon::find()
            ->select('s.*')
            ->alias('s')
            ->leftJoin(SalonSpecialization::tableName() . ' ss', '`s`.`id` = `ss`.`salon_id`')
            ->leftJoin(Service::tableName() . ' ser', 'ser.account_id = s.account_id')
            ->leftJoin(MasterSchedule::tableName() . ' ms', '`s`.`id` = `ms`.`salon_id`');

        if ($form->validate()) {
            $queryUsers
                ->filterWhere(['us.specialization_id' => $form->specialization])
                ->andFilterWhere(['ser.common_service_id' => $form->service])
                ->andFilterWhere(['up.city_id' => $form->city])
                ->andFilterWhere(['date(usch.start_date)' => $form->date]);

            $querySalons
                ->filterWhere(['ss.specialization_id' => $form->specialization])
                ->andFilterWhere(['ser.common_service_id' => $form->service])
                ->andFilterWhere(['s.city_id' => $form->city])
                ->andFilterWhere(['date(ms.start_date)' => $form->date]);
        }

        $users = $queryUsers->asArray()->all();
        $salons = $querySalons->asArray()->all();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user['id'],
                'name' => $user['name'] . ' ' . $user['surname'],
                'address' => $user['address'],
                'city_id' => $user['city_id'],
                //'schedules' => $user['schedules'],
                'services' => $this->getUserService($user['id']),
                'like' => $this->getUserAssessment($user['id'], Recall::ASSESSMENT_LIKE),
                'dislike' => $this->getUserAssessment($user['id'], Recall::ASSESSMENT_DISLIKE),
                'isSalon' => false,
//                'validTime' => $this->getValidTime($form->time, $user['id'], $form->date),
                'latitude' => $user['latitude'],
                'longitude' => $user['longitude']
            ];
        }

        foreach ($salons as $salon) {
            $data[] = [
                'id' => $salon['id'],
                'name' => $salon['name'],
                'address' => $salon['address'],
                'city_id' => $salon['city_id'],
                //'schedules' => $salon['schedules'],
                'services' => $this->getSalonService($salon['id']),
                'like' => $this->getSalonAssessment($salon['id'], Recall::ASSESSMENT_LIKE),
                'dislike' => $this->getSalonAssessment($salon['id'], Recall::ASSESSMENT_DISLIKE),
                'isSalon' => true,
//                'validTime' => $this->getValidTimeSalon($form->time, $salon['id'], $form->date),
                'latitude' => $salon['latitude'],
                'longitude' => $salon['longitude']
            ];
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->setData([
            'form' => $form,
            'dataProvider' => $dataProvider,
            'items' => $data
        ]);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function findUser($id)
    {
        if (($model = User::find()
                ->with(['specializations'])
                ->with(['profile'])
                ->where(['id' => $id])
                ->one()) == null) throw new \Exception('Not find any user');
        $specialization = $this->getSpecializationServiceByAccountId($model->account_id);

        $this->setData(['model' => $model, 'specialization' => $specialization]);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function findSalon($id)
    {
        if (($model = Salon::find()
                ->with(['specializations'])
                ->with(['masters'])
                ->where(['id' => $id])
                ->one()) == null) throw new \Exception('Not find any salon');
        $specialization = $this->getSpecializationServiceByAccountId($model->account_id);

        $this->setData(['model' => $model, 'specialization' => $specialization]);
    }

    /**
     * @param $userId
     * @param $assessment
     * @return int|string
     */
    public function getUserAssessment($userId, $assessment)
    {
        return Recall::find()->where(['user_id' => $userId])->andWhere(['assessment' => $assessment])->count();
    }

    /**
     * @param $userId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getUserService($userId)
    {
        $accountId = User::find()->select('account_id')->where(['id' => $userId])->one()['account_id'];

        return Service::find()->where(['account_id' => $accountId])->asArray()->all();
    }

    /**
     * @param $salonId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSalonService($salonId)
    {
        return SalonService::find()->where(['salon_id' => $salonId])->asArray()->all();
    }

    /**
     * @param $salonId
     * @param $assessment
     * @return int|string
     */
    public function getSalonAssessment($salonId, $assessment)
    {
        $accountId = Salon::find()->select('account_id')->where(['id' => $salonId])->one()['account_id'];

        return Recall::find()->where(['account_id' => $accountId])->andWhere(['assessment' => $assessment])->count();
    }

    /**
     * @param $accountId
     * @return array
     */
    public function getSpecializationServiceByAccountId($accountId)
    {
        if (!$this->specializationService) {
            $specializations = Specialization::find()
                ->alias('sp')
                ->leftJoin(Service::tableName() . ' serv', 'serv.specialization_id = sp.id')
                ->where(['serv.account_id' => $accountId])
                ->all();
            $this->specializationService = [];

            foreach ($specializations as $specialization) {
                $specializationService[] = [
                    'name' => $specialization['name'],
                    'service' => $this->getServiceBySpecializationId($specialization['id'], $accountId),
                ];
            }
        }

        return $specializationService ?? null;
    }

    /**
     * @param int $specializationId
     * @param int $accountId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getServiceBySpecializationId(int $specializationId, int $accountId)
    {
        return Service::find()
            ->select(['name', 'price', 'specialization_id'])
            ->where(['specialization_id' => $specializationId])
            ->andWhere(['account_id' => $accountId])
            ->asArray()
            ->all();
    }
}
