<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
use api\models\lk\MasterService;

/**
 * Class MasterServiceType
 *
 * @package api\graphql\lk\types\entity
 */
class MasterServiceType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'masterServices' => [
                'type' => $typeRegistry->listOff($entityRegistry->masterService()),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return MasterService::find()
                        ->byMasterId($args['master_id'])
                        ->bySalonId($args['salon_id'])
                        ->allByCurrentAccountId();
                }
            ]
        ];
    }


}