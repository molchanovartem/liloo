<?php

namespace api\graphql\common\types\entity;

use GraphQL\Type\Definition\Type;
use common\models\Convenience;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;

/**
 * Class ConvenienceType
 *
 * @package api\graphql\common\types\entity
 */
class ConvenienceType extends \api\graphql\base\types\entity\CommonServiceType implements QueryTypeInterface
{
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
                    return Convenience::find()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->all();
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