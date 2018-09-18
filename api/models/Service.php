<?php

namespace api\models;

use common\behaviors\AccountBehavior;
use api\buffers\BufferInterface;
use api\buffers\ServiceBuffer;
use api\queries\ServiceQuery;

/**
 * Class Service
 *
 * @package api\models
 */
class Service extends \common\models\Service implements BufferInterface
{
    const SCENARIO_SERVICE = 'service';
    const SCENARIO_GROUP = 'group';

    /**
     * @var null
     */
    private static $buffer = null;

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

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            // Устанавлеваем тип услуги в зависимости от сценария
            ['is_group', 'default', 'value' => function ($model) {
                return $model->scenario === self::SCENARIO_SERVICE ? 0 : 1;
            }],
            [['specialization_id', 'price', 'duration'], 'required', 'on' => self::SCENARIO_SERVICE],
            // Проверяем наличие группы в текущем аккаунте
            ['parent_id', 'exist', 'targetClass' => static::class, 'targetAttribute' => 'id', 'filter' => function ($query) {
                $query->isGroup()
                    ->byCurrentAccountId();
            }, 'when' => function ($model) {
                return is_numeric($model->parent_id);
            }],
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
     * @return ServiceQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }

    /**
     * @return ServiceBuffer|null
     */
    public static function buffer()
    {
        return self::$buffer ?? (self::$buffer = new ServiceBuffer(get_called_class()));
    }


}