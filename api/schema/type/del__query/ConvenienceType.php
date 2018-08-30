<?php

namespace api\schema\type\query;

use api\models\Convenience;
use api\schema\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class ConvenienceType
 * @package api\schema\query
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
                    'id' => $typeRegistry->int(),
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
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'conveniences' => [
                'type' => $typeRegistry->listOff($queryRegistry->convenience()),
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
                'type' => $queryRegistry->specialization(),
                'args' => ['id' => Type::nonNull(Type::int())],
                'resolve' => function ($root, $args) {
                    return Convenience::find()->oneById($args['id']);
                }
            ],
        ];
    }


}