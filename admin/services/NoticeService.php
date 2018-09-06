<?php

namespace admin\services;

use admin\models\Notice;
use admin\core\service\ModelService;
use yii\data\ActiveDataProvider;

class NoticeService extends ModelService
{
    public function getDataProvider()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Notice::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        $this->setData(['provider' => $dataProvider]);
    }

    public function delete($id)
    {
        $this->findNotice($id);

        return $this->getData()['notice']->delete();
    }

    public function findNotice($id)
    {
        if (($model = Notice::findOne($id)) == null) throw new \Exception('Not find any notice');

        $this->setData(['notice' => $model]);
    }
}