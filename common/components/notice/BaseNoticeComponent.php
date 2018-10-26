<?php

namespace common\components\notice;

use yii\base\Component;
use common\models\UserProfile;
use admin\models\AdminNotice;
use common\components\notice\models\admin\ClientComplaintNoticeData;
use common\components\notice\models\admin\UserRegisterNoticeData;
use common\components\notice\models\site\UserCanceledSessionNoticeData;
use common\models\Notice;

/**
 * Class BaseNoticeComponent
 * @package common\components\notice
 */
abstract class BaseNoticeComponent extends Component
{
    abstract function getNotice();
    /**
     * @param int $type
     * @param int $status
     * @param $text
     * @param $data
     * @return mixed|void
     */
    function createNotice(int $type, int $status, $text, $data)
    {
        $notice = $this->getNotice();

        $notice->type = $type;
        $notice->status = $status;
        $notice->text = $text;
        $notice->data = $this->currentModel($type, $data);;

        $notice->save(false);
    }

    /**
     * @param int $id
     * @return mixed
     */
    abstract function checkNotice(int $id);

    /**
     * @param int $type
     * @return mixed
     */
    protected function getTypeData(int $type)
    {
        return $this->getNoticeDataList()[$type];
    }

    /**
     * @return array
     */
    protected function getNoticeDataList()
    {
        return [
            Notice::TYPE_USER_CANCELED_SESSION => new UserCanceledSessionNoticeData(),
            AdminNotice::TYPE_USER_REGISTRATION => new UserRegisterNoticeData(),
            AdminNotice::TYPE_CLIENT_COMPLAINT => new ClientComplaintNoticeData(),
        ];
    }

    /**
     * @param UserProfile $model
     * @return false|string
     */
    function convertModelToUserRegistrationModel(UserProfile $model)
    {
        $newModel = new UserRegisterNoticeData();

        $newModel->userId = $model->user_id;
        $newModel->phone = $model->phone;

        return json_encode($newModel);
    }

    /**
     * @param $model
     * @return array
     */
    protected function getNoticeDataMethods($model)
    {
        return [
            AdminNotice::TYPE_USER_REGISTRATION => call_user_func([$this, 'convertModelToUserRegistrationModel'], $model),
        ];
    }

    /**
     * @param int $type
     * @param $model
     * @return mixed
     */
    protected function currentModel(int $type, $model)
    {
        return $this->getNoticeDataMethods($model)[$type];
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
        if (($model = ($this->getNotice())::findOne($id)) == null) throw new \Exception('Not find any notice');

        return $model;
    }
}
