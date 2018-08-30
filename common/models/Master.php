<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\AccountBehavior;
use common\queries\MasterQuery;

/**
 * Class Master
 *
 * @package common\models
 */
class Master extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%master}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'name'], 'required'],
            [['account_id', 'user_id'], 'integer'],
            [['surname', 'name', 'patronymic'], 'string', 'max' => 255],
            ['date_birth', 'date', 'format' => 'php:Y-m-d']
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            AccountBehavior::class
        ];
    }

    public static function find()
    {
        return new MasterQuery(get_called_class());
    }

    /**
     * @param int $id
     * @return int
     */
    public static function deleteById(int $id)
    {
        return self::deleteAll([
            'id' => $id,
            'account_id' => Yii::$app->account->getId()
        ]);
    }
}