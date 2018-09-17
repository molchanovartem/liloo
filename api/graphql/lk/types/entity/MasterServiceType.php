<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\MasterService;

/**
 * Class MasterServiceType
 *
 * @package api\graphql\lk\types\entity
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