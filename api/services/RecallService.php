<?php

namespace api\services;

use admin\models\Notice;
use api\exceptions\AttributeValidationError;
use api\models\Recall;
use common\models\Appointment;
use Yii;
use yii\base\Event;

/**
 * Class RecallService
 * @package api\services
 */
class RecallService extends Service
{
    const EVENT_USER_RECALL = 'recall';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_USER_RECALL, function ($model) {
            Yii::$app->adminNotice->createNotice(Notice::TYPE_USER_RECALL, Notice::STATUS_UNREAD, 'text', $model->sender);
        });
    }
    /**
     * @param array $attributes
     * @param $type
     * @param $modelScenario
     * @return Recall
     * @throws AttributeValidationError
     */
    public function create(array $attributes, $type, $modelScenario)
    {
        return $this->save(new Recall(), $attributes, $type, $modelScenario);
    }

    /**
     * @param Recall $model
     * @param array $attributes
     * @param $type
     * @param $modelScenario
     * @return Recall
     * @throws AttributeValidationError
     */
    private function save(Recall $model, array $attributes, $type, $modelScenario)
    {
        $model->setAttributes($attributes);
        $model->setScenario($modelScenario);
        $model->type = $type;
        $model->account_id = $this->setAccountId($model->appointment_id);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        $this->trigger(self::EVENT_USER_RECALL, new Event(['sender' => $model]));
        return $model;
    }

    /**
     * @param $appointmentId
     * @return mixed
     */
    private function setAccountId($appointmentId)
    {
        return Appointment::find()->where(['id' => $appointmentId])->one()['account_id'];
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool)Recall::deleteById($id);
    }
}