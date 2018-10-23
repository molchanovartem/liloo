<?php

namespace api\graphql\base\types\entity;

use common\models\SalonSpecialization;
use common\models\SalonConvenience;
use api\graphql\core\EntityType;
use common\models\Master;
use common\models\SalonMaster;
use common\models\Convenience;
use common\models\Specialization;
use common\models\Salon;

/**
 * Class SalonType
 *
 * @package api\graphql\base\types\entity
 */
class SalonType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'account_id' => $this->typeRegistry->id(),
            'user_id' => $this->typeRegistry->id(),
            'country_id' => $this->typeRegistry->id(),
            'city_id' => $this->typeRegistry->id(),
            'status' => $this->typeRegistry->int(),
            'name' => $this->typeRegistry->string(),
            'address' => $this->typeRegistry->string(),
            'phone' => $this->typeRegistry->string(),
            'latitude' => $this->typeRegistry->decimal(),
            'longitude' => $this->typeRegistry->decimal(),
            'specializations' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->specialization()),
                'description' => 'Коллекция специализаций',
                'resolve' => function (Salon $salon, $args, $context, $info) {
                    return Specialization::find()
                        ->alias('s')
                        ->leftJoin(SalonSpecialization::tableName() . 'ss', '`s`.`id` = `ss`.`specialization_id`')
                        ->where(['ss.salon_id' => $salon->id])
                        ->all();
                }
            ],
            'conveniences' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->convenience()),
                'description' => 'Коллекция удобств',
                'resolve' => function (Salon $salon, $args, $context, $info) {
                    return Convenience::find()
                        ->alias('c')
                        ->leftJoin(SalonConvenience::tableName() . 'sc', '`c`.`id` = `sc`.`convenience_id`')
                        ->where(['sc.salon_id' => $salon->id])
                        ->all();
                }
            ],
            'masters' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->master()),
                'resolve' => function (Salon $model, $args) {
                    return Master::find()
                        ->alias('m')
                        ->leftJoin(SalonMaster::tableName() . ' sm', '`m`.`id` = `sm`.`master_id`')
                        ->where(['sm.salon_id' => $model->id])
                        ->all();
                }
            ]
        ];
    }
}