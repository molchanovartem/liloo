<?php

namespace api\graphql\lk\services;

use common\core\service\ModelService;
use Yii;
use yii\base\Event;
use admin\models\AdminNotice;
use api\graphql\core\errors\AttributeValidationError;
use api\models\lk\Recall;
use common\models\Appointment;

/**
 * Class RecallService
 *
 * @package api\graphql\lk\services
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
        $model->account_id = $this->setAccountId($model, $type);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        $this->trigger(self::EVENT_USER_RECALL, new Event(['sender' => $model]));

        return $model;
    }

    /**
     * @param $model
     * @param $type
     * @return mixed
     */
    private function setAccountId($model, $type)
    {
        if ($type) {
            return Recall::find()
                ->select('lu_appointment.account_id')
                ->leftJoin('lu_appointment', 'lu_appointment.id = lu_recall.appointment_id')
                ->where(['lu_recall.id' => $model->parent_id])
                ->one()['account_id'];
        }

        return Appointment::find()->where(['id' => $model->appointment_id])->one()['account_id'];
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
