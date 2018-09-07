<?php

namespace admin\services;

use admin\models\User;
use admin\core\service\ModelService;
use admin\models\UserInteraction;
use yii\data\ActiveDataProvider;

/**
 * Class UserService
 * @package admin\services
 */
class UserService extends ModelService
{
    public function getDataProvider()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        $this->setData(['provider' => $dataProvider]);
    }

    /**
     * @param $type
     * @param array $params
     * @return bool
     */
    public function save($type, $params = [])
    {
        $type == 'create' ? $model = new User() : $model = User::find()->where(['id' => $params['id']])->one();
        $this->setData([
            'model' => $model
        ]);

        return $model->load($this->getData('post')) && $model->save();
    }

    /**
     * @param $userId
     * @return bool
     */
    public function saveInteraction($userId)
    {
        $model = new UserInteraction(['user_id' => $userId]);
        $this->setData([
            'model' => $model,
        ]);

        return $model->load($this->getData('post')) && $model->save();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->findUser($id);

        return $this->getData()['user']->delete();
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function findUser($id)
    {
        if (($model = User::findOne($id)) == null) throw new \Exception('Not find any user');

        $this->setData(['user' => $model]);
    }

    /**
     * @param $id
     */
    public function findUserInteraction($id)
    {
        $this->setData(['interactions' => UserInteraction::find()->where(['user_id' => $id])->all()]);
    }
}