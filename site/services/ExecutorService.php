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
class ExecutorService extends ModelService
{
    public function index()
    {
        $form = new FilterForm();
        $form->load($this->getData('get'));

        $queryUsers = User::find()
            ->select(['u.*', 'up.name', 'up.surname', 'up.address', 'up.city_id'])
            ->alias('u')
            ->leftJoin(UserSpecialization::tableName() . ' us', '`u`.`id` = `us`.`user_id`')
            ->leftJoin(Service::tableName() . ' ser', 'ser.account_id = u.account_id')
            ->leftJoin(UserProfile::tableName() . ' up', '`u`.`id` = `up`.`user_id`')
            ->leftJoin(UserSchedule::tableName() . ' usch', '`u`.`id` = `usch`.`user_id`')
            ->with(['schedules']);

        $querySalons = Salon::find()
            ->select('s.*')
            ->alias('s')
            ->leftJoin(SalonSpecialization::tableName() . ' ss', '`s`.`id` = `ss`.`salon_id`')
            ->leftJoin(Service::tableName() . ' ser', 'ser.account_id = s.account_id')
            ->leftJoin(MasterSchedule::tableName() . ' ms', '`s`.`id` = `ms`.`salon_id`')
            ->with(['schedules']);

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
                'schedules' => $user['schedules'],
                'specializations' => $this->getUserSpecialization($user['id']),
                'service' => $this->getUserService($user['id']),
                'like' => $this->getUserAssessment($user['id'], Recall::ASSESSMENT_LIKE),
                'dislike' => $this->getUserAssessment($user['id'], Recall::ASSESSMENT_DISLIKE),
                'isSalon' => false,
                'validTime' => $this->getValidTime($form->time, $user['id']),
            ];
        }

        foreach ($salons as $salon) {
            $data[] = [
                'id' => $salon['id'],
                'name' => $salon['name'],
                'address' => $salon['address'],
                'city_id' => $salon['city_id'],
                'schedules' => $salon['schedules'],
                'service' => $this->getSalonService($salon['id']),
                'like' => $this->getSalonAssessment($salon['id'], Recall::ASSESSMENT_LIKE),
                'dislike' => $this->getSalonAssessment($salon['id'], Recall::ASSESSMENT_DISLIKE),
                'isSalon' => true,
//                'validTime' => $this->getValidTimeSalon($form->time, $salon['id']),
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
            'dataProvider' => $dataProvider
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

        $this->setData(['executor' => $model]);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function findSalon($id)
    {
        if (($model = Salon::find()
                ->with(['specializations'])
                ->with(['users'])
                ->where(['id' => $id])
                ->one()) == null) throw new \Exception('Not find any salon');

        $this->setData(['executor' => $model]);
    }

    /**
     * @param $userId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getUserSpecialization($userId)
    {
        return Specialization::find()
            ->alias('s')
            ->leftJoin(UserSpecialization::tableName() . ' us', 's.id = us.specialization_id')
            ->where(['us.user_id' => $userId])
            ->asArray()
            ->all();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getNearTimeUser($userId)
    {
        return Appointment::find()->where(['user_id' => $userId])->max('end_date');
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
     * @param $userId
     * @return array
     */
    public function getCurrentTime(int $userId)
    {
        $userSchedules = UserSchedule::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $userAppointments = Appointment::find()->select('start_date, end_date')->where(['user_id' => $userId])->all();
        $appointmentTime = [];
        $time = [];

        foreach (FilterForm::getPartTime() as $item) {
            foreach ($userSchedules as $userSchedule) {
                $currentDay = date_format(date_create($userSchedule->start_date), 'Y-m-d');

                if ($userSchedule->start_date < $currentDay . ' ' . $item && $userSchedule->end_date > $currentDay . ' ' . $item) {
                    $time[] = $item;
                }
            }
        }

        foreach ($time as $k => $t) {
            foreach ($userAppointments as $userAppointment) {
                if ($userAppointment->start_date <= $currentDay . ' ' . $t && $userAppointment->end_date >= $currentDay . ' ' . $t) {
                    $appointmentTime[] = $t;
                }
            }
        }

        return array_diff($time, $appointmentTime);
    }


    /**
     * @param null $time
     * @param $userId
     * @return array
     */
    public function getValidTime($time = null, $userId)
    {
        if ($time == null) {
            return $this->getCurrentTime($userId);
        }

        return array_intersect($time, $this->getCurrentTime($userId));
    }

//    public function getCurrentTimeSalon($salonId)
//    {
//        $masterSchedules = MasterSchedule::find()->select('master_id, start_date, end_date')->where(['salon_id' => $salonId])->all();
//        $masterAppointments = Appointment::find()->select('master_id, start_date, end_date')->where(['salon_id' => $salonId])->all();
//
//        $appointmentTime = [];
//        $time = [];
//
//        foreach (FilterForm::getPartTime() as $item) {
//            foreach ($masterSchedules as $masterSchedule) {
//                $currentDay = date_format(date_create($masterSchedule->start_date), 'Y-m-d');
//
//                if ($masterSchedule->start_date < $currentDay . ' ' . $item && $masterSchedule->end_date > $currentDay . ' ' . $item) {
//                    $time[$item] = $masterSchedule->master_id;
//                }
//            }
//        }
//        die();
//        foreach ($time as $k => $t) {
//            foreach ($masterAppointments as $masterAppointment) {
//                if ($masterAppointment->start_date <= $currentDay . ' ' . $t && $masterAppointment->end_date >= $currentDay . ' ' . $t) {
//
//
//                    $appointmentTime[$t] = $masterAppointment->master_id;
//                }
//            }
//        }
//
////        $times = [];
////
////        foreach ()
//        var_dump($time);
//        echo '------------------------------';
//        var_dump($appointmentTime);
//        die;
//
//        return array_diff_assoc($time, $appointmentTime);
////        $kek = [];
////        foreach ($times as $time) {
////            foreach ($time as $t) {
////                $kek[] = $t;
////            }
////        }
////
////        return array_unique($kek);
//    }
//
//    /**
//     * @param null $time
//     * @param $salonId
//     * @return array
//     */
//    public function getValidTimeSalon($time = null, $salonId)
//    {
//        if ($time == null) {
//            return $this->getCurrentTimeSalon($salonId);
//        }
//
//        return array_intersect($time, $this->getCurrentTimeSalon($salonId));
//    }
}
