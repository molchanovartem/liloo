<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;
use common\models\Service;

/**
 * Class ServiceType
 *
 * @package api\graphql\base\types\entity
 */
class ServiceType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'account_id' => $this->typeRegistry->id(),
            'parent_id' => $this->typeRegistry->id(),
            'specialization_id' => $this->typeRegistry->id(),
            'name' => $this->typeRegistry->string(),
            'price' => $this->typeRegistry->string(),
            'duration' => $this->typeRegistry->int(),
            'specialization' => [
                'type' => $this->entityRegistry->specialization(),
                'resolve' => function (Service $service, $args, $context, $info) {
                    /*
                     * @todo
                     */
                }
            ]
        ];
    }
}