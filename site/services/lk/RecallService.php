<?php

namespace site\services\lk;

use Yii;
use yii\base\Event;
use admin\models\AdminNotice;
use api\graphql\core\errors\AttributeValidationError;
use common\core\service\ModelService;
use site\models\Recall;

/**
 * Class RecallService
 * @package site\services\lk
 */
class RecallService extends ModelService
{
    const EVENT_USER_RECALL = 'recall';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_USER_RECALL, function ($model) {
            Yii::$app->adminNotice->createNotice(AdminNotice::TYPE_USER_RECALL, AdminNotice::STATUS_UNREAD, 'text', $model->sender);
        });
    }

    public function gerRecalls()
    {
        $this->setData([
            'recalls' => Recall::find()->andWhere(['user_id' => Yii::$app->user->getId()])->with('answer')->all(),
        ]);
    }

    /**
     * @param $accountId
     * @param $appointmentId
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteRecall(int $id)
    {
        Recall::findOne($id)->delete();
    }
}
