<?php

namespace api\graphql\base\types\entity;

use common\models\SalonMaster;
use api\graphql\core\EntityType;
use common\models\Master;

/**
 * Class SalonMasterType
 *
 * @package api\graphql\base\types\entity
 */
class SalonMasterType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'salon_id' => $this->typeRegistry->id(),
            'master_id' => $this->typeRegistry->id(),
            'master' => [
                'type' => $this->entityRegistry->master(),
                'resolve' => function (SalonMaster $model, $args) {
                    return Master::find()->oneById($model->master_id);
                }
            ]
        ];
    }
}