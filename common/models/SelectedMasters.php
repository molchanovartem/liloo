<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\queries\Query;

/**
 * Class SelectedMasters
 * @package common\models
 */
class SelectedMasters extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%selected_masters}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'executor_id', 'is_salon'], 'integer'],
        ];
    }

    /**
     * @return Query|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new Query(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'executor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalon()
    {
        return $this->hasOne(Salon::class, ['id' => 'executor_id']);
    }
}
