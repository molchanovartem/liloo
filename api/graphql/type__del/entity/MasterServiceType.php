<?php

namespace api\schema\type\entity;

use api\models\MasterService;
use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class MasterServiceType
 *
 * @package api\schema\type\entity
 */
class MasterServiceType extends ObjectType implements QueryTypeInterface
{
    /**
     * MasterServiceType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'service_id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id()
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
            'masterServices' => [
                'type' => $typeRegistry->listOff($entityRegistry->masterService()),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return MasterService::find()->allByParams($args['master_id'], $args['salon_id']);
                }
            ]
        ];
    }


}