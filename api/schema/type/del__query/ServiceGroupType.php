<?php

namespace api\schema\type\query;

use api\models\Service;
use api\schema\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;

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
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'serviceGroups' => [
                'type' => $typeRegistry->listOff($queryRegistry->serviceGroup()),
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
                'type' => $queryRegistry->serviceGroup(),
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