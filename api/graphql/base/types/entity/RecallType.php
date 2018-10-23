<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;
use common\models\Recall;

/**
 * Class RecallType
 *
 * @package api\graphql\base\types\entity
 */
class RecallType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'user_id' => $this->typeRegistry->id(),
            'appointment_id' => $this->typeRegistry->id(),
            'parent_id' => $this->typeRegistry->id(),
            'text' => $this->typeRegistry->string(),
            'assessment' => $this->typeRegistry->int(),
            'type' => $this->typeRegistry->int(),
            'create_time' => $this->typeRegistry->dateTime(),
            'response' => [
                'type' => $this->entityRegistry->recall(),
                'description' => 'Ответ',
                'resolve' => function (Recall $recall, $args, $context, $info) {
                    return Recall::find()
                        ->where(['parent_id' => $recall->id])
                        ->one();
                }
            ],
        ];
    }
}
