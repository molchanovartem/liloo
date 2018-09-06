<?php

namespace admin\services;

use admin\models\User;
use admin\core\service\ModelService;
use admin\models\UserInteraction;
use yii\data\ActiveDataProvider;

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

    public function save($type, $params = [])
    {
        $type == 'create' ? $model = new User() : $model = User::find()->one($params['id']);
        $this->setData([
            'model' => $model
        ]);

        return $model->load($this->getData('post')) && $model->save();
    }

    public function saveInteraction($userId)
    {
        $model = new UserInteraction(['user_id' => $userId]);
        $this->setData([
            'model' => $model,
        ]);

        return $model->load($this->getData('post')) && $model->save();
    }

    public function delete($id)
    {
        $this->findUser($id);

        return $this->getData()['user']->delete();
    }

    public function findUser($id)
    {
        if (($model = User::findOne($id)) == null) throw new \Exception('Not find any user');

        $this->setData(['user' => $model]);
    }

    public function findUserInteraction($id)
    {
        $this->setData(['interactions' => UserInteraction::find()->where(['user_id' => $id])->all()]);
    }
}