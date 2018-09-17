<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\Service;

/**
 * Class ServiceGroupType
 *
 * @package api\graphql\lk\types\entity
 */
class ServiceGroupType extends ObjectType implements QueryTypeInterface
{
    /**
     * ServiceGroupType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'parent_id' => $typeRegistry->id(),
                    'is_group' => $typeRegistry->int(),
                    'name' => $typeRegistry->string()
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
            'serviceGroups' => [
                'type' => $typeRegistry->listOff($entityRegistry->serviceGroup()),
                'args' => [
                    'parent_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Service::find()->allGroupByParentId($args['parent_id']);
                }
            ],
            'serviceGroup' => [
                'type' => $entityRegistry->serviceGroup(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return Service::find()->oneGroupById($args['id']);
                }
            ]
        ];
    }

}