<?php

namespace admin\services;

use admin\models\Recall;
use common\core\service\ModelService;

/**
 * Class RecallService
 * @package admin\services
 */
class RecallService extends ModelService
{
    public function getAllRecalls()
    {
        $this->setData(['recalls' => Recall::find()->all()]);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function findRecall($id)
    {
        if (($model = Recall::findOne($id)) == null) throw new \Exception('Not find any recall');

        $this->setData(['recall' => $model]);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function check($id)
    {
        $this->findRecall($id);
        $data = $this->getData();
        $this->save($data['recall']);
    }

    /**
     * @param $model
     * @return mixed
     */
    public function save($model)
    {
        $model->status = Recall::STATUS_VERIFIED;

        return $model->save();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->findRecall($id);

        return $this->getData()['recall']->delete();
    }

}