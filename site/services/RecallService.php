<?php

namespace site\services;

use Yii;
use yii\base\Event;
use admin\models\AdminNotice;
use api\graphql\core\errors\AttributeValidationError;
use common\core\service\ModelService;
use site\models\Recall;
use site\forms\ComplaintForm;
use common\models\Notice;

/**
 * Class RecallService
 * @package site\services
 */
class RecallService extends ModelService
{
    const EVENT_USER_RECALL = 'recall';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_USER_RECALL, function ($model) {
            Yii::$app->siteNotice->createNotice(100, Notice::TYPE_USER_RECALL, Notice::STATUS_UNREAD, 'text', $model->sender);
        });
    }

    public function gerRecalls()
    {
        $this->setData([
            'recalls' => Recall::find()->andWhere(['user_id' => Yii::$app->user->getId()])->with('answer')->all(),
            'complaint' => new ComplaintForm(),
        ]);
    }

    /**
     * @param int $accountId
     * @param int $appointmentId
     * @param $assessment
     * @param $text
     *
     * @throws AttributeValidationError
     */
    public function createRecall(int $accountId, int $appointmentId, $assessment, $text)
    {
        $model = new Recall();

        $model->type = Recall::RECALL_TYPE_USER;
        $model->appointment_id = $appointmentId;
        $model->account_id = $accountId;
        $model->assessment = $assessment;
        $model->text = $text;

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        $this->trigger(self::EVENT_USER_RECALL, new Event(['sender' => $model]));

        $this->setData(['recall' => $model]);
    }

    /**
     * @param int $id
     */
    public function deleteRecall(int $id)
    {
        Recall::deleteAll('id = :id OR parent_id = :id', [':id' => $id]);
    }

    public function complaint()
    {
        $complaint = new ComplaintForm();
        $complaint->load($this->getData('post'));
        $recall = $this->getRecall($complaint->recallId);

        Yii::$app->adminNotice->createNotice(
            AdminNotice::TYPE_CLIENT_COMPLAINT,
            AdminNotice::STATUS_UNREAD,
            $complaint->getComplaint(),
            $recall
        );
    }

    /**
     * @param $id
     * @return array|bool|null|\yii\db\ActiveRecord
     */
    public function getRecall($id)
    {
        return Recall::find()->where(['id' => $id])->one() ?? false;
    }
}
