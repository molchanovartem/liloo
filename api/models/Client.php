<?php

namespace api\models;

use Yii;
use api\buffers\BufferInterface;
use api\buffers\ClientBuffer;
use api\queries\ClientQuery;
use common\validators\CityExistValidator;
use common\validators\CountryExistValidator;
use common\behaviors\AccountBehavior;

/**
 * Class Client
 * @package api\models
 */
class Client extends \common\models\Client implements BufferInterface
{
    /**
     * @var null
     */
    private static $buffer = null;

    /**
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['country_id', CountryExistValidator::class],
            ['city_id', CityExistValidator::class],
        ]);
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

    /**
     * @return ClientQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ClientQuery(get_called_class());
    }

    /**
     * @return ClientBuffer|null
     */
    public static function buffer()
    {
        return self::$buffer ?? (self::$buffer = new ClientBuffer(self::find()));
    }

    /**
     * @param int $id
     * @return int
     */
    public static function deleteOneById(int $id)
    {
        return self::deleteAll([
            'id' => $id,
            'account_id' => Yii::$app->account->getId()
        ]);
    }
}