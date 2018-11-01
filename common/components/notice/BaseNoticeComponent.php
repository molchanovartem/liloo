<?php

namespace common\components\notice;

use yii\base\Component;
use common\components\notice\models\site\ClientRecallNoticeData;
use common\models\Appointment;
use common\models\Recall;
use common\models\UserProfile;
use admin\models\AdminNotice;
use common\components\notice\models\admin\ClientComplaintNoticeData;
use common\components\notice\models\admin\UserRegisterNoticeData;
use common\components\notice\models\site\UserCanceledSessionNoticeData;

/**
 * Class BaseNoticeComponent
 * @package common\components\notice
 */
abstract class BaseNoticeComponent extends Component
{
    /**
     * @return mixed
     */
    abstract function getNoticeModel();

    /**
     * @param int $type
     * @param int $status
     * @param string $text
     * @param $data
     */
    function createNotice(int $type, int $status, string $text, $data)
    {
        $notice = $this->getNoticeModel();

        $notice->type = $type;
        $notice->status = $status;
        $notice->text = $text;
        $notice->data = $this->currentModel($type, $data);

        $notice->save(false);
    }

    /**
     * @param int $id
     * @return mixed
     */
    abstract function checkNotice(int $id);

    /**
     * @param UserProfile $model
     * @return false|string
     */
    function createUserRegisterNoticeData(UserProfile $model)
    {
        $newModel = new UserRegisterNoticeData();

        $newModel->userId = $model->user_id;
        $newModel->phone = $model->phone;

        return json_encode($newModel);
    }

    /**
     * @param Recall $model
     * @return false|string
     */
    function createClientComplaintNoticeData(Recall $model)
    {

        $newModel = new ClientComplaintNoticeData();

        $newModel->recallId = $model->id;
        $newModel->text = $model->text;

        return json_encode($newModel);
    }

    /**
     * @param Appointment $model
     * @return false|string
     */
    function createUserCanceledSessionNoticeData(Appointment $model)
    {
        $newModel = new UserCanceledSessionNoticeData();

        $newModel->appointmentId = $model->id;
        $newModel->startDate = $model->start_date;
        $newModel->clientId = $model->client_id;

        return json_encode($newModel);
    }

    /**
     * @param Recall $model
     * @return false|string
     */
    function createClientRecallNoticeData(Recall $model)
    {
        $newModel = new ClientRecallNoticeData();

        $newModel->recallId = $model->id;
        $newModel->text = $model->text;

        return json_encode($newModel);
    }

    abstract function getNoticeDataMethods($type, $model);

    /**
     * @param int $type
     * @param $model
     * @return mixed
     */
    protected function currentModel(int $type, $model)
    {
        return $this->getNoticeDataMethods($type, $model);
    }

    /**
     * @param int $id
     * @return false|int|mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteNotice(int $id)
    {
        return $this->findNotice($id)->delete();
    }

    /**
     * @param int $id
     * @return AdminNotice|null
     * @throws \Exception
     */
    public function findNotice(int $id)
    {
        if (($model = ($this->getNoticeModel())::findOne($id)) == null) throw new \Exception('Not find any notice');

        return $model;
    }
}
