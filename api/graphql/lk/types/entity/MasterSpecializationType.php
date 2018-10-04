<?php

namespace api\graphql\lk\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\lk\MasterSpecialization;

/**
 * Class MasterSpecializationType
 *
 * @package api\graphql\lk\types\entity
 */
class MasterSpecializationType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'masterSpecializations' => [
                'type' => $typeRegistry->listOff($entityRegistry->masterSpecialization()),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return MasterSpecialization::find()
                        ->byMasterId($args['master_id'])
                        ->allByCurrentAccountId();
                }
            ]
        ];
    }
}