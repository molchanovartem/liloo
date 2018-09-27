<?php

namespace site\services;

use common\core\service\ModelService;
use common\models\Appointment;
use common\models\MasterSchedule;
use common\models\Recall;
use common\models\Salon;
use common\models\SalonService;
use common\models\SalonSpecialization;
use common\models\Service;
use common\models\User;
use common\models\UserProfile;
use common\models\UserSchedule;
use common\models\UserSpecialization;
use site\forms\FilterForm;

/**
 * Class ExecutorService
 * @package site\services
 */
class ExecutorService extends ModelService
{
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
            $userIds[] = $user['id'];
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
                'validTime' => $this->getValidTime($form->time, $user['id'], $form->date),
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
                'validTime' => $this->getValidTimeSalon($form->time, $salon['id'], $form->date),
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

        $this->setData(['model' => $model]);
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

        $this->setData(['model' => $model]);
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
     * @param int $userId
     * @param $currentDate
     * @return array
     */
    public function getCurrentTime(int $userId, $currentDate)
    {
        $userSchedules = UserSchedule::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $userAppointments = Appointment::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $appointmentTime = [];
        $times = [];

        foreach (FilterForm::getPartTime() as $partTime) {
            foreach ($userSchedules as $userSchedule) {
                if ($userSchedule->start_date <= $currentDate . ' ' . $partTime && $userSchedule->end_date > $currentDate . ' ' . $partTime) {
                    $times[] = $partTime;
                }
            }
        }

        foreach ($times as $time) {
            foreach ($userAppointments as $userAppointment) {
                if ($userAppointment->start_date <= $currentDate . ' ' . $time && $userAppointment->end_date >= $currentDate . ' ' . $time) {
                    $appointmentTime[] = $time;
                }
            }
        }

        return array_diff($times, $appointmentTime);
    }


    /**
     * @param null $times
     * @param $userId
     * @param $currentDate
     * @return array
     */
    public function getValidTime($times = null, $userId, $currentDate)
    {
        if ($times == null) {
            return $this->getCurrentTime($userId, $currentDate);
        }

        return array_intersect($times, $this->getCurrentTime($userId, $currentDate));
    }

    /**
     * @param $salonId
     * @param $currentDate
     * @return array
     */
    public function getCurrentTimeSalon($salonId, $currentDate)
    {
        $masterSchedules = MasterSchedule::find()->select('master_id, start_date, end_date')->where(['salon_id' => $salonId])->all();
        $masterAppointments = Appointment::find()->select('master_id, start_date, end_date')->where(['salon_id' => $salonId])->all();

        $appointmentTime = [];
        $time = [];
        $currentTime = [];

        foreach (FilterForm::getPartTime() as $partTime) {
            foreach ($masterSchedules as $masterSchedule) {
                if ($masterSchedule->start_date < $currentDate . ' ' . $partTime && $masterSchedule->end_date > $currentDate . ' ' . $partTime) {
                    $time[] = $partTime . '->' . $masterSchedule->master_id;
                }
            }
        }

        foreach (FilterForm::getPartTime() as $partTime) {
            foreach ($masterAppointments as $masterAppointment) {
                if ($masterAppointment->start_date < $currentDate . ' ' . $partTime && $masterAppointment->end_date > $currentDate . ' ' . $partTime) {
                    $appointmentTime[] = $partTime . '->' . $masterAppointment->master_id;
                }
            }
        }

        foreach (array_diff($time, $appointmentTime) as $item) {
            $currentTime[] = explode('->', $item)[0];
        }

        return array_unique($currentTime);
    }

    /**
     * @param $masterId
     * @param $currentDate
     * @return array
     */
    public function getCurrentTimeSalonMaster($masterId, $currentDate)
    {
        $userSchedules = MasterSchedule::find()->select('start_date, end_date')->where(['master_id' => $masterId])->all();
        $userAppointments = Appointment::find()->select('start_date, end_date')->where(['master_id' => $masterId])->all();
        $appointmentTime = [];
        $times = [];

        foreach (FilterForm::getPartTime() as $partTime) {
            foreach ($userSchedules as $userSchedule) {
                if ($userSchedule->start_date < $currentDate . ' ' . $partTime && $userSchedule->end_date > $currentDate . ' ' . $partTime) {
                    $times[] = $partTime;
                }
            }
        }

        foreach ($times as $time) {
            foreach ($userAppointments as $userAppointment) {
                if ($userAppointment->start_date <= $currentDate . ' ' . $time && $userAppointment->end_date >= $currentDate . ' ' . $time) {
                    $appointmentTime[] = $time;
                }
            }
        }

        return array_diff($times, $appointmentTime);
    }

    /**
     * @param null $times
     * @param $salonId
     * @param $currentDate
     * @return array
     */
    public function getValidTimeSalon($times = null, $salonId, $currentDate)
    {
        if ($times == null) {
            return $this->getCurrentTimeSalon($salonId, $currentDate);
        }

        return array_intersect($times, $this->getCurrentTimeSalon($salonId, $currentDate));
    }

    /**
     * @param array $serviceIds
     * @return mixed
     */
    public function getServiceSumTime(array $serviceIds)
    {
        return Service::find()->where(['in', 'id', $serviceIds])->sum('duration');
    }

    /**
     * @param array $serviceIds
     * @return mixed
     */
    public function getServiceSumPrice(array $serviceIds)
    {
        return Service::find()->where(['in', 'id', $serviceIds])->sum('price');
    }

    /**
     * @param array $time
     * @param $userId
     * @param $workTime
     * @param $date
     * @return array
     */
    public function getFreePartTime(array $time, $userId, $workTime, $date)
    {
        $userAppointments = Appointment::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $error = [];
        $success = [];

        foreach ($time as $t) {
            $endSession = $this->sumTime($t, $workTime);
            $j = $t;
            while ($j != $endSession) {
                foreach ($userAppointments as $userAppointment) {
                    if ($userAppointment->start_date <= $date . ' ' . $j . ':00' && $userAppointment->end_date >= $date . ' ' . $j . ':00') {
                        $error[] = $j;
                    }
                }

                $j = $this->sumTime($j, '00:15');
            }

            if (empty($error)) {
                $success[] = $t;
            }
        }

        return $success;
    }

    /**
     * @param $i
     * @param $k
     * @return false|string
     */
    public function sumTime($i, $k)
    {
        return date('H:i', strtotime($i) + strtotime($k) - strtotime("00:00:00"));
    }
}
