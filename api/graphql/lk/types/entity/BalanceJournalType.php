<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\BalanceJournal;

/**
 * Class BalanceJournalType
 *
 * @package api\graphql\lk\types\entity
 */
class BalanceJournalType extends ObjectType implements QueryTypeInterface
{
    /**
     * BalanceJournalType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'type_operation' => $typeRegistry->int(),
                    'type_operation_name' => [
                        'type' => $typeRegistry->string(),
                        'resolve' => function (BalanceJournal $model) {
                            return $model->getTypeOperationName();
                        }
                    ],
                    'type_reason' => $typeRegistry->int(),
                    'type_reason_name' => [
                        'type' => $typeRegistry->string(),
                        'resolve' => function (BalanceJournal $model) {
                            return $model->getTypeReasonName();
                        }
                    ],
                    'sum' => $typeRegistry->decimal(),
                    'data_reason' => [
                        'type' => $typeRegistry->string(),
                        'resolve' => function (BalanceJournal $model) {
                            return json_encode($model->data_reason);
                        }
                    ],
                ];
            }
        ]);
    }
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'balanceJournal' => [
                'type' => $typeRegistry->listOff($entityRegistry->balanceJournal()),
                'description' => 'Журнал',
                'resolve' => function ($root, $args) {
                    return BalanceJournal::find()->allByAccountId();
                }
            ],
        ];
    }
}