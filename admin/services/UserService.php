<?php

namespace admin\services;

use admin\models\User;
use admin\core\service\Service;
use admin\models\UserInteraction;

class UserService extends Service
{
    protected $model;

    public function create()
    {
        $this->setData([
            'model' => $this->model = new User()
        ]);

        return $this->save();
    }

    public function update($id)
    {
        $this->setData([
            'model' => $this->model = User::find()->one($id)
        ]);

        return $this->save();
    }

    private function save()
    {
        return $this->model->load($this->getData('post')) && $this->model->save();
    }

    public function createInteraction($userId)
    {
        $model = new UserInteraction();
        $model->user_id = $userId;
        $this->setData([
            'model' => $this->model = $model,
        ]);

        return $this->save();
    }
}