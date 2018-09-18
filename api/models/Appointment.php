<?php

namespace api\models;

use api\queries\AppointmentQuery;

/**
 * Class Appointment
 * @package api\models
 */
class Appointment extends \common\models\Appointment
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['client_id', function ($attribute) {
                $client = Client::find()
                    ->where(['id' => $this->$attribute])
                    ->andWhere(['account_id' => $this->account_id])
                    ->one();
                if (empty($client)) {
                    $this->addError($attribute, 'Данному аккаунту не принадлежит этот клиент');
                }
            }],
            ['master_id', function ($attribute) {
                $client = Master::find()
                    ->where(['id' => $this->$attribute])
                    ->andWhere(['account_id' => $this->account_id])
                    ->one();
                if (empty($client)) {
                    $this->addError($attribute, 'Данному аккаунту не принадлежит этот мастер');
                }
            }],
            ['salon_id', function ($attribute) {
                $client = Salon::find()
                    ->where(['id' => $this->$attribute])
                    ->andWhere(['account_id' => $this->account_id])
                    ->one();
                if (empty($client)) {
                    $this->addError($attribute, 'Данному аккаунту не принадлежит этот салон');
                }
            }],
        ]);
    }


    /**
     * @return AppointmentQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new AppointmentQuery(get_called_class());
    }
}