<?php

namespace api\graphql\common\types\entity;

use common\models\CommonService;
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
            'commonServices' => [
                'type' => $typeRegistry->listOff($entityRegistry->commonService()),
                'description' => 'Коллекция базовых услуг',
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
                    return CommonService::find()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->all();
                }
            ],
            'commonService' => [
                'type' => $entityRegistry->commonService(),
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id())
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return CommonService::find()->oneById($args['id']);
                }
            ],
        ];
    }
}