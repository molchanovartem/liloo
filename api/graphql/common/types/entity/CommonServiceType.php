<?php

namespace api\graphql\common\types\entity;

use common\models\Service;
use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;

/**
 * Class CommonServiceType
 *
 * @package api\graphql\common\types\entity
 */
class CommonServiceType extends \api\graphql\base\types\entity\CommonServiceType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'services' => [
                'type' => $typeRegistry->listOff($entityRegistry->commonService()),
                'description' => 'Коллекция базовых услуг',
                'args' => [
                    'parent_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                    'limit' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 30,
                    ],
                    'offset' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => 0
                    ]
                ],
                'description' => 'Коллекция услуг',
                'resolve' => function ($root, $args) {
                    return Service::find()->where(['parent_id' => $args['parent_id']])
                        ->isService()
                        ->limit($args['limit'])
                        ->offset($args['offset'])->all();
                }
            ],
            'service' => [
                'type' => $entityRegistry->commonService(),
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id())
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Service::find()->oneById($args['id']);
                }
            ],
        ];
    }
}