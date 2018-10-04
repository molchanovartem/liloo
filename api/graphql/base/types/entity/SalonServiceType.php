<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;
use common\models\SalonService;

/**
 * Class SalonServiceType
 *
 * @package api\graphql\base\types\entity
 */
class SalonServiceType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'salon_id' => $this->typeRegistry->id(),
            'service_id' => $this->typeRegistry->id(),
            'service_price' => $this->typeRegistry->decimal(),
            'service_duration' => $this->typeRegistry->int(),
            'service' => [
                'type' => $this->entityRegistry->service(),
                'resolve' => function (SalonService $model, $args) {
//                    Service::buffer()->addKey($model->service_id);
//
//                    return new Deferred(function () use ($model, $args) {
//                        return Service::buffer()->oneServiceById($model->service_id);
//                    });

                    return \common\models\Service::find()
                        ->oneById($model->service_id);
                }
            ]
        ];
    }
}