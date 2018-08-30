<?php

namespace common\models;

use Yii;

/**
 * Class ServiceToService
 * @package common\models
 */
class ServiceToService extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%service_to_service}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['parent_id', 'service_id'], 'required'],
            [['parent_id', 'service_id'], 'integer'],
            [['parent_id', 'service_id'], 'unique', 'targetAttribute' => ['parent_id', 'service_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => Yii::t('app', 'Parent ID'),
            'service_id' => Yii::t('app', 'Service ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Service::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }
}
