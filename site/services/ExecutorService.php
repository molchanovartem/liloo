<?php

namespace site\services;

use common\models\Convenience;
use common\models\SalonConvenience;
use common\models\UserConvenience;
use yii\base\DynamicModel;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Account;
use common\core\service\ModelService;
use common\helpers\FreeDateTime;
use common\models\Appointment;
use common\models\MasterSchedule;
use common\models\Recall;
use common\models\Salon;
use common\models\SalonService;
use common\models\SalonSpecialization;
use common\models\SelectedMasters;
use common\models\Service;
use common\models\Specialization;
use common\models\User;
use common\models\UserProfile;
use common\models\UserSchedule;
use common\models\UserSpecialization;

/**
 * Class ExecutorService
 *
 * @package site\services
 */
class ExecutorService extends ModelService
{
    private $specializationService = [];

    public function index()
    {
        $filter = $this->createFilterModel();
        $filter->load($this->getData('get'), '');

        $items = [];
        if ($filter->validate()) {
            $items = array_merge(
                $this->getUserItems($filter->getAttributes()),
                $this->getSalonItems($filter->getAttributes())
            );
        }

        $this->setData([
            'items' => $items
        ]);
    }

    /**
     * @return DynamicModel
     */
    private function createFilterModel()
    {
        return (new DynamicModel(['specialization_id', 'city_id', 'service_id', 'date_time']))
            ->addRule(['city_id', 'date_time'], 'required')
            ->addRule(['specialization_id', 'city_id', 'service_id'], 'integer')
            ->addRule(['date_time'], 'date', ['format' => 'php:Y-m-d H:i:s']);
    }

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private function getUserItems(array $params)
    {
        $arUsers = User::find()
            ->alias('t1')
            ->select(['t1.*', 't4.name', 't4.surname', 't4.address', 't4.city_id', 't4.latitude', 't4.longitude', 't6.assessment_like', 't6.assessment_dislike'])
            ->leftJoin(UserSpecialization::tableName() . ' t2', '`t1`.`id` = `t2`.`user_id`')
            ->leftJoin(Service::tableName() . ' t3', '`t3`.`account_id` = `t1`.`account_id`')
            ->leftJoin(UserProfile::tableName() . ' t4', '`t1`.`id` = `t4`.`user_id`')
            ->leftJoin(UserSchedule::tableName() . ' t5', '`t1`.`id` = `t5`.`user_id`')
            ->leftJoin(Account::tableName() . ' t6', '`t6`.`id` = `t1`.`account_id`')
            ->where(['t4.city_id' => $params['city_id']])
            ->andWhere(new Expression('DATE(`t5`.`start_date`) = DATE(:date)', ['date' => $params['date_time']]))
            ->andFilterWhere(['t2.specialization_id' => $params['specialization_id']])
            ->andFilterWhere(['t3.common_service_id' => $params['service_id']])
            ->asArray()
            ->all();

        $appointments = $this->getAppointments('user_id', ArrayHelper::getColumn($arUsers, 'id'), $params['date_time']);

        $arSchedules = UserSchedule::find()
            ->where(['in', 'user_id', ArrayHelper::getColumn($arUsers, 'id')])
            ->andWhere(new Expression('DATE(`start_date`) = DATE(:date)', ['date' => $params['date_time']]))
            ->asArray()
            ->all();

        $arSpecializations = Specialization::find()
            ->alias('t1')
            ->select(['t1.*', 't2.user_id', 't2.specialization_id'])
            ->leftJoin(UserSpecialization::tableName() . ' t2', '`t1`.`id` = `t2`.`specialization_id`')
            ->where(['in', 't2.user_id', ArrayHelper::getColumn($arUsers, 'id')])
            ->asArray()
            ->all();

        $arServices = Service::find()
            ->where(['in', 'account_id', ArrayHelper::getColumn($arUsers, 'account_id')])
            ->andWhere(['!=', 'common_service_id', 'null'])
            ->asArray()
            ->all();

        $arConveniences = Convenience::find()
            ->alias('t1')
            ->select(['t1.*', 't2.user_id', 't2.convenience_id'])
            ->leftJoin(UserConvenience::tableName() . ' t2', '`t1`.`id` = `t2`.`convenience_id`')
            ->where(['in', 't2.user_id', ArrayHelper::getColumn($arUsers, 'id')])
            ->asArray()
            ->all();

        $conveniences = [];
        foreach ($arConveniences as $convenience) {
            $conveniences[$convenience['user_id']][] = $convenience;
        }

        $specializations = ArrayHelper::map($arSpecializations, 'specialization_id', function ($item) {
            return ['id' => $item['specialization_id'], 'name' => $item['name']];
        }, 'user_id');

        $selectedService = null;
        $services = [];
        foreach ($arServices as $arService) {
            $service = [
                'id' => $arService['id'],
                'name' => $arService['name'],
                'price' => $arService['price'],
                'duration' => $arService['duration']
            ];

            if ($arService['common_service_id'] && $params['service_id']) $selectedService = $service;

            $services[$arService['account_id']][] = $service;
        }


        $schedules = [];
        foreach ($arSchedules as $schedule) {
            $schedules[$schedule['user_id']][] = $schedule;
        }

        $items = [];
        foreach ($arUsers as &$user) {
            $isShow = false;

            $periods = [];
            if (!empty($schedules[$user['id']])) {
                $freeTime = new FreeDateTime($schedules[$user['id']], $appointments[$user['id']] ?? []);

                $unaccountedTime = $selectedService ? $selectedService['duration'] * 60 : null;

                foreach ($freeTime->getPeriods(30, $unaccountedTime, true) as $period) {
                    if (strtotime($period) > strtotime($params['date_time'])) {
                        $isShow = true;

                        $periods[] = $period;
                    } else continue;
                }
            }

            if (!$isShow) continue;

            $items[] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'address' => $user['address'],
                'specializations' => $specializations[$user['id']] ?? [],
                'conveniences' => $conveniences[$user['id']] ?? [],
                'services' => $services[$user['account_id']] ?? [],
                'freeTime' => array_unique($periods, SORT_REGULAR),
                'isSalon' => false,
                'latitude' => $user['latitude'],
                'longitude' => $user['longitude'],
                'assessment_like' => $user['assessment_like'],
                'assessment_dislike' => $user['assessment_dislike']
            ];
        }
        return $items;
    }

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private function getSalonItems(array $params)
    {
        $arSalons = Salon::find()
            ->alias('t1')
            ->select(['t1.*', 't6.assessment_like', 't6.assessment_dislike'])
            ->leftJoin(SalonSpecialization::tableName() . ' t2', '`t1`.`id` = `t2`.`salon_id`')
            ->leftJoin(SalonService::tableName() . ' t3', '`t1`.`id` = `t3`.`salon_id`')
            ->leftJoin(Service::tableName() . ' t4', '`t4`.`id` = `t3`.`service_id`')
            ->leftJoin(MasterSchedule::tableName() . ' t5', '`t1`.`id` = `t5`.`salon_id`')
            ->leftJoin(Account::tableName() . ' t6', '`t6`.`id` = `t1`.`account_id`')
            ->where(['t1.city_id' => $params['city_id']])
            ->andWhere(new Expression('DATE(`t5`.`start_date`) = DATE(:date)', ['date' => $params['date_time']]))
            ->andFilterWhere(['t2.specialization_id' => $params['specialization_id']])
            ->andFilterWhere(['t4.common_service_id' => $params['service_id']])
            ->groupBy('`t1`.`id`')
            ->asArray()
            ->all();

        $salonAppointments = $this->getAppointments('salon_id', ArrayHelper::getColumn($arSalons, 'id'), $params['date_time']);

        $schedules = MasterSchedule::find()
            ->where(['in', 'salon_id', ArrayHelper::getColumn($arSalons, 'id')])
            ->andWhere(new Expression('DATE(`start_date`) = DATE(:date)', ['date' => $params['date_time']]))
            ->orderBy(['start_date' => SORT_ASC])
            ->asArray()
            ->all();

        $arConveniences = Convenience::find()
            ->alias('t1')
            ->select(['t1.*', 't2.salon_id', 't2.convenience_id'])
            ->leftJoin(SalonConvenience::tableName() . ' t2', '`t1`.`id` = `t2`.`convenience_id`')
            ->where(['in', 't2.salon_id', ArrayHelper::getColumn($arSalons, 'id')])
            ->asArray()
            ->all();

        $conveniences = [];
        foreach ($arConveniences as $convenience) {
            $conveniences[$convenience['salon_id']][] = $convenience;
        }

        $arSpecializations = Specialization::find()
            ->alias('t1')
            ->select(['t1.*', 't2.salon_id', 't2.specialization_id'])
            ->leftJoin(SalonSpecialization::tableName() . ' t2', '`t1`.`id` = `t2`.`specialization_id`')
            ->where(['in', 't2.salon_id', ArrayHelper::getColumn($arSalons, 'id')])
            ->asArray()
            ->all();

        $specializations = ArrayHelper::map($arSpecializations, 'specialization_id', function ($item) {
            return ['id' => $item['specialization_id'], 'name' => $item['name']];
        }, 'salon_id');

        $salonServices = SalonService::find()
            ->select(['t1.*', 't2.name', 't2.common_service_id'])
            ->alias('t1')
            ->leftJoin(Service::tableName(). ' t2', '`t2`.`id` = `t1`.`service_id`')
            ->where(['in', 't1.salon_id', ArrayHelper::getColumn($arSalons, 'id')])
            ->andWhere(['!=', 't2.common_service_id', 'null'])
            ->asArray()
            ->all();

        $selectedService = null;
        $services = [];
        foreach ($salonServices as $salonService) {
            $service = [
                'id' => $salonService['service_id'],
                'name' => $salonService['name'],
                'price' => $salonService['service_price'],
                'duration' => $salonService['service_duration']
            ];

            if ($salonService['common_service_id'] && $params['service_id']) $selectedService = $service;

            $services[$salonService['salon_id']][] = $service;
        }

        $salonSchedules = [];
        foreach ($schedules as &$schedule) {
            $salonSchedules[$schedule['salon_id']][] = $schedule;
        }

        $items = [];
        foreach ($arSalons as &$salon) {
            $isShow = false;
            $periods = [];

            if (!empty($salonSchedules[$salon['id']])) {
                $freeTime = new FreeDateTime($salonSchedules[$salon['id']], $salonAppointments[$salon['id']] ?? []);

                $unaccountedTime = $selectedService ? $selectedService['duration'] * 60 : null;

                foreach ($freeTime->getPeriods(30, $unaccountedTime, true) as $period) {
                    if (strtotime($period) > strtotime($params['date_time'])) {
                        $isShow = true;

                        $periods[] = $period;
                    } else continue;
                }
            }

            if (!$isShow) continue;

            $items[] = [
                'id' => $salon['id'],
                'name' => $salon['name'],
                'address' => $salon['address'],
                'specializations' => $specializations[$salon['id']] ?? [],
                'conveniences' => $conveniences[$salon['id']] ?? [],
                'services' => $services[$salon['id']] ?? [],
                'freeTime' => array_unique($periods, SORT_REGULAR),
                'isSalon' => true,
                'latitude' => $salon['latitude'],
                'longitude' => $salon['longitude'],
                'assessment_like' => $salon['assessment_like'],
                'assessment_dislike' => $salon['assessment_dislike']
            ];
        }

        return $items;
    }

    /**
     * @param string $by
     * @param array $in
     * @param string $date
     * @return array
     */
    private function getAppointments(string $by, array $in, string $date)
    {
        $appointments = Appointment::find()
            ->where(['in', $by, $in])
            ->andWhere(new Expression('DATE(`start_date`) = DATE(:date)', ['date' => $date]))
            ->orderBy(['start_date' => SORT_ASC])
            ->asArray()
            ->all();

        $byAppointments = [];
        foreach ($appointments as &$appointment) {
            $byAppointments[$appointment[$by]][] = $appointment;
        }
        return $byAppointments;
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
        $isSelected = SelectedMasters::find()->where(['executor_id' => $id])->byCurrentUserId()->one() ? 1 : 0;

        $this->setData(['model' => $model, 'specialization' => $specialization, 'isSelected' => $isSelected]);
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
        $isSelected = SelectedMasters::find()->where(['executor_id' => $id])->byCurrentUserId()->one() ? 1 : 0;

        $this->setData(['model' => $model, 'specialization' => $specialization, 'isSelected' => $isSelected]);
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
