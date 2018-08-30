<?php

namespace api\schema\type\query;

use api\models\Specialization;
use api\schema\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class SpecializationType
 * @package api\schema\query
 */
class SpecializationType extends ObjectType implements QueryTypeInterface
{
    /**
     * SpecializationType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $queryRegistry) {
                return [
                    'id' => $typeRegistry->int(),
                    'name' => [
                        'type' => $typeRegistry->string(),
                        'description' => 'Название'
                    ],
                    'description' => [
                        'type' => $typeRegistry->string(),
                        'description' => 'Описание'
                    ]
                ];
            }
        ];

        parent::__construct($config);
    }

    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'specializations' => [
                'type' => $typeRegistry->listOff($queryRegistry->specialization()),
                'description' => 'Коллекция специализаций',
                'args' => [
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Specialization::find()->allByParams($args['limit'], $args['offset']);
                }
            ],
            'specialization' => [
                'type' => $queryRegistry->specialization(),
                'args' => ['id' => $typeRegistry->nonNull($typeRegistry->int())],
                'resolve' => function ($root, $args) {
                    return Specialization::find()->oneById($args['id']);
                }
            ],
        ];
    }


}