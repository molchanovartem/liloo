<?php

namespace common\models;

//use common\behaviors\file\ActionImage;
use Yii;

/**
 * Class Portfolio
 * @package common\models
 */
class Portfolio extends \yii\db\ActiveRecord
{
    public $imageDelete;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%portfolio}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['account_id', 'sort', 'name'], 'required'],
            [['account_id', 'salon_id', 'service_id', 'sort', 'imageDelete'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
            ['image', 'image']
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
     * @return array
     */
    public static function modelAttributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account_id' => Yii::t('app', 'Account'),
            'salon_id' => Yii::t('app', 'Salon'),
            'service_id' => Yii::t('app', 'Service'),
            'sort' => Yii::t('app', 'Sort'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'create_time' => Yii::t('app', 'Create time'),
            'update_time' => Yii::t('app', 'Update time'),
        ];
    }

    /*
    public function behaviors()
    {
        return [
            [
                'class' => ActionImage::class,
                'attribute' => 'image',
                'deleteAttribute' => 'imageDelete',
                'path' => '@webroot/public/uploads/images',
                'pathUrl' => '@web/public/uploads/images'
            ]
        ];
    }
    */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalon()
    {
        return $this->hasOne(Salon::className(), ['id' => 'salon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioImages()
    {
        return $this->hasMany(PortfolioImage::className(), ['portfolio_id' => 'id'])
            ->orderBy(['sort' => SORT_ASC]);
    }
}
