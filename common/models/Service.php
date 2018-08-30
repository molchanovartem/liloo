<?php

namespace common\models;

use common\behaviors\AccountBehavior;
use common\queries\ServiceQuery;
use Yii;

/**
 * Class Service
 * @package common\models
 */
class Service extends \yii\db\ActiveRecord
{
    const SCENARIO_SERVICE = 'service';
    const SCENARIO_GROUP = 'group';

    public function scenarios()
    {
        $defaultAttribute = ['account_id', 'parent_id', 'is_group', 'name'];

        return [
            self::SCENARIO_GROUP => $defaultAttribute,
            self::SCENARIO_SERVICE => array_merge($defaultAttribute, [
                'specialization_id', 'price', 'duration'
            ])
        ];
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%service}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        /*
         * @todo
         * Проверять на существование specialization_id
         */

        return [
            // Устанавлеваем тип услуги в зависимости от сценария
            ['is_group', 'default', 'value' => function ($model) {
                return $model->scenario === self::SCENARIO_SERVICE ? 0 : 1;
            }],
            [['account_id', 'is_group', 'name'], 'required'],
            [['specialization_id', 'price', 'duration'], 'required', 'on' => self::SCENARIO_SERVICE],
            // Проверяем наличие группы в текущем аккаунте
            ['parent_id', 'exist', 'targetClass' => Service::class, 'targetAttribute' => 'id', 'filter' => function ($query) {
                $query->isGroup()
                    ->byAccountId();
            }, 'when' => function ($model) {
                return is_numeric($model->parent_id);
            }],
            [['account_id', 'parent_id', 'salon_id', 'duration', 'specialization_id'], 'integer'],
            [['price'], 'number'],
            ['price', 'string', 'max' => 15],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @return array
     */
    /*
    public function rules(): array
    {
        return [
            [['account_id', 'specialization_id', 'name', 'price', 'duration'], 'required'],
            [['account_id', 'parent_id', 'user_id', 'salon_id', 'duration', 'specialization_id'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255]
        ];
    }
    */

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
     * @return array
     */
    public static function modelAttributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account_id' => Yii::t('app', 'Account'),
            'salon_id' => Yii::t('app', 'Salon'),
            'specialization_id' => Yii::t('app', 'Specialization'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'duration' => Yii::t('app', 'Duration'),
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return self::modelAttributeLabels();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialization()
    {
        //return $this->hasOne(Specialization::class, ['id' => 'specialization_id']);
    }

    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }
}
