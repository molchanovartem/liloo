<?php

namespace api\models;

use api\queries\SalonUserQuery;
use common\behaviors\AccountBehavior;

/**
 * Class SalonUser
 *
 * @package api\models
 */
class SalonUser extends \common\models\SalonUser
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['salon_id', 'exist', 'targetClass' => Salon::class, 'filter' => function ($query) {
                $query->isAccount();
            }]
        ]);
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            AccountBehavior::class
        ];
    }

    /**
     * @return SalonUserQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new SalonUserQuery(get_called_class());
    }
}