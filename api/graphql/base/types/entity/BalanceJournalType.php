<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;
use common\models\BalanceJournal;

/**
 * Class BalanceJournalType
 *
 * @package api\graphql\base\types\entity
 */
class BalanceJournalType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'type_operation' => $this->typeRegistry->int(),
            'type_operation_name' => [
                'type' => $this->typeRegistry->string(),
                'resolve' => function (BalanceJournal $model) {
                    return $model->getTypeOperationName();
                }
            ],
            'type_reason' => $this->typeRegistry->int(),
            'type_reason_name' => [
                'type' => $this->typeRegistry->string(),
                'resolve' => function (BalanceJournal $model) {
                    return $model->getTypeReasonName();
                }
            ],
            'sum' => $this->typeRegistry->decimal(),
            'data_reason' => [
                'type' => $this->typeRegistry->string(),
                'resolve' => function (BalanceJournal $model) {
                    return json_encode($model->data_reason);
                }
            ],
        ];
    }
}