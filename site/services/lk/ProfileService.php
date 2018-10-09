<?php

namespace site\services\lk;

use yii\helpers\ArrayHelper;
use common\core\service\ModelService;
use common\models\City;
use common\models\Country;
use common\models\User;
use common\models\UserProfile;

/**
 * Class ProfileService
 *
 * @package site\services\lk
 */
class ProfileService extends ModelService
{
    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function findUser($id)
    {
        if (($model = User::find()
                          ->with(['profile'])
                          ->where(['id' => $id])
                          ->one()) == null) throw new \Exception('Not find any user');

        $this->setData(['model' => $model]);
    }

    /**
     * @param $id
     */
    public function update($id)
    {
        $model = UserProfile::find()->where(['user_id' => $id])->one();
        $cities = $this->getCities();
        $countries = $this->getCountries();

        $this->setData([
            'model' => $model,
            'cities' => $cities,
            'countries' => $countries,
            ]);

        $model->load($this->getData('post')) && $model->save();
    }

    /**
     * @return array
     */
    protected function getCities()
    {
        $array = City::find()->select('*')->asArray()->all();

        return ArrayHelper::map($array, 'id', 'name');
    }

    /**
     * @return array
     */
    protected function getCountries()
    {
        $array = Country::find()->select('*')->asArray()->all();

        return ArrayHelper::map($array, 'id', 'name');
    }
}
