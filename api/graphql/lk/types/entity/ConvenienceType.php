<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\Convenience;

/**
 * Class ConvenienceType
 *
 * @package api\graphql\lk\types\entity
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