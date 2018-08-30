<?php

namespace common\models;

use common\queries\Query;
use Yii;

/**
 * Class UserConvenience
 *
 * @package common\models
 */
class UserConvenience extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_convenience}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'convenience_id'], 'required'],
            [['user_id', 'convenience_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'convenience_id' => Yii::t('app', 'Convenience ID'),
        ];
    }

    public static function find()
    {
        return new Query(get_called_class());
    }
}
