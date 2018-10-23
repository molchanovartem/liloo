<?php

namespace api\graphql\lk\types\entity;

use common\models\BalanceJournal;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;

/**
 * Class BalanceJournalType
 *
 * @package api\graphql\lk\types\entity
 */
class BalanceJournalType implements QueryTypeInterface
{
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
                    return BalanceJournal::find()->allByCurrentAccountId();
                }
            ],
        ];
    }
}