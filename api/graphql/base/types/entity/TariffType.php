<?php

namespace api\graphql\base\types\entity;

use common\models\TariffPrice;
use common\models\Tariff;
use api\graphql\EntityType;

/**
 * Class TariffType
 *
 * @package api\graphql\base\types\entity
 */
class TariffType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'name' => $this->typeRegistry->string(),
            'description' => $this->typeRegistry->string(),
            'type' => $this->typeRegistry->int(),
            'status' => $this->typeRegistry->int(),
            'quantity' => $this->typeRegistry->int(),
            'price' => [
                'type' => $this->entityRegistry->tariffPrice(),
                'args' => [
                    'id' => $this->typeRegistry->nonNull($this->typeRegistry->id())
                ],
                'resolve' => function (Tariff $model, $args) {
                    return TariffPrice::find()
                        ->byId($args['id'])
                        ->byTariffId($model->id)
                        ->one();
                }
            ],
            'prices' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->tariffPrice()),
                'resolve' => function (Tariff $tariff, $args, $context, $info) {
                    return TariffPrice::find()
                        ->where(['tariff_id' => $tariff->id])
                        ->all();
                }
            ],
        ];
    }
}