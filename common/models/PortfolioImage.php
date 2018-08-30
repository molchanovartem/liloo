<?php

namespace common\models;

use Yii;
use common\behaviors\file\ActionImage;

/**
 * Class PortfolioImage
 * @package common\models
 */
class PortfolioImage extends \yii\db\ActiveRecord
{
    public $isDelete;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%portfolio_image}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['sort', 'default', 'value' => 500],
            [['account_id', 'portfolio_id', 'sort'], 'required'],
            [['account_id', 'portfolio_id', 'sort', 'isDelete'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            ['file', 'image']
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
            'portfolio_id' => Yii::t('app', 'Portfolio'),
            'sort' => Yii::t('app', 'Sort'),
            'file' => Yii::t('app', 'File'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
          [
              'class' => ActionImage::class,
              'attribute' => 'file',
              'deleteAttribute' => 'isDelete',
              'path' => '@webroot/public/uploads/images',
              'pathUrl' => '@web/public/uploads/images'
          ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }

    /**
     * @return \common\queries\PortfolioImageQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \common\queries\PortfolioImageQuery(get_called_class());
    }
}
