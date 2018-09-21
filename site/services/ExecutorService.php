<?php

namespace site\services;

use common\core\service\ModelService;
use common\models\Salon;
use common\models\SalonSpecialization;
use common\models\Specialization;
use common\models\User;
use common\models\UserProfile;
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

        if (!$form->validate()) {
            return false;
        }

        $users = User::find()
            ->select('u.*, up.name, up.surname, up.address, up.city_id')
            ->alias('u')
            ->leftJoin(UserSpecialization::tableName() . ' us', '`u`.`id` = `us`.`user_id`')
            ->leftJoin(UserProfile::tableName() . ' up', '`u`.`id` = `up`.`user_id`')
            ->filterWhere(['us.specialization_id' => $this->getData('get')['specialization']])
            ->andFilterWhere(['up.city_id' => $this->getData('get')['city']])
            ->with(['schedules'])
            ->asArray()
            ->all();

        $salons = Salon::find()
            ->select('*')
            ->alias('s')
            ->leftJoin(SalonSpecialization::tableName() . ' ss', '`s`.`id` = `ss`.`salon_id`')
            ->filterWhere(['ss.specialization_id' => $this->getData('get')['specialization']])
//            ->where(['s.city_id' => $city_id])
            ->with(['schedules'])
            ->asArray()
            ->all();

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user['id'],
                'name' => $user['name'] . ' ' . $user['surname'],
                'address' => $user['address'],
                'city_id' => $user['city_id'],
                'schedules' => $user['schedules'],
                'specializations' => $this->getUserSpecialization($user['id']),
                'isSalon' => false,
            ];
        }

        foreach ($salons as $salon) {
            $data[] = [
                'id' => $salon['id'],
                'name' => $salon['name'],
                'address' => $salon['address'],
                'city_id' => $salon['city_id'],
                'schedules' => $salon['schedules'],
                'isSalon' => true,
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
            'provider' => $dataProvider
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

    public function getUserSpecialization($userId)
    {
        return Specialization::find()
            ->alias('s')
            ->leftJoin(UserSpecialization::tableName() . ' us', 's.id = us.specialization_id')
            ->where(['us.user_id' => $userId])
            ->asArray()
            ->all();
    }
}
