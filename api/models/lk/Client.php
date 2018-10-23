<?php

namespace api\models\lk;

use Yii;
use common\validators\CityExistValidator;
use common\validators\CountryExistValidator;
use common\behaviors\AccountBehavior;
use api\graphql\core\BufferInterface;
use api\graphql\lk\buffers\ClientBuffer;

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