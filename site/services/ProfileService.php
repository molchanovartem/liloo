<?php

namespace site\services;

use Yii;
use yii\helpers\ArrayHelper;
use common\core\service\ModelService;
use common\models\City;
use common\models\Country;
use common\models\User;
use common\models\UserProfile;

/**
 * Class ProfileService
 * @package site\services
 */
class ProfileService extends ModelService
{
    /**
     * @throws \Exception
     */
    public function findUser()
    {
        if (($model = User::find()
                ->with(['profile'])
                ->where(['id' => Yii::$app->user->getId()])
                ->one()) == null) throw new \Exception('Not find any user');

        $this->setData(['model' => $model]);
    }

    public function update()
    {
        $model = UserProfile::find()->where(['user_id' => Yii::$app->user->getId()])->one();

        if (!empty($this->getData('post'))) {
            $model->load($this->getData('post'));
            $model->phone = (int)filter_var($this->getData('post')['UserProfile']['phone'], FILTER_SANITIZE_NUMBER_INT);

            $model->save();
        }
        $cities = $this->getCities();
        $countries = $this->getCountries();

        $this->setData([
            'model' => $model,
            'cities' => $cities,
            'countries' => $countries,
        ]);
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
