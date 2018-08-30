<?php

namespace api\schema\type\entity;

use api\models\Convenience;
use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class ConvenienceType
 *
 * @package api\schema\type\entity
 */
class ConvenienceType extends ObjectType implements QueryTypeInterface
{
    /**
     * ConvenienceType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $config = [
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'name' => [
                        'type' => $typeRegistry->string(),
                        'description' => 'Название'
                    ],
                    'description' => [
                        'type' => $typeRegistry->int(),
                        'description' => 'Описание'
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'conveniences' => [
                'type' => $typeRegistry->listOff($entityRegistry->convenience()),
                'description' => 'Коллекция удобств',
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
                    return Convenience::find()->allByParams($args['limit'], $args['offset']);
                }
            ],
            'convenience' => [
                'type' => $entityRegistry->convenience(),
                'args' => [
                    'id' => Type::nonNull(Type::id())
                ],
                'resolve' => function ($root, $args) {
                    return Convenience::find()->oneById($args['id']);
                }
            ],
        ];
    }


}