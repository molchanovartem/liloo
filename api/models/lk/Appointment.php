<?php

namespace api\models\lk;

use common\behaviors\AccountBehavior;
use common\behaviors\UserId;
use common\models\Client;
use common\models\Master;
use common\models\Salon;

/**
 * Class Appointment
 *
 * @package api\models\lk
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
     * @return array
     */
    public function behaviors()
    {
        return [
            UserId::class,
            AccountBehavior::class
        ];
    }
}