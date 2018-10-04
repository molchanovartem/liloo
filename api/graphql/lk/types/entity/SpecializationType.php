<?php

namespace api\graphql\lk\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use common\models\Specialization;

/**
 * Class SpecializationType
 *
 * @package api\graphql\lk\types\entity
 */
class SpecializationType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'specializations' => [
                'type' => $typeRegistry->listOff($entityRegistry->specialization()),
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
                    return Specialization::find()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->all();
                }
            ],
            'specialization' => [
                'type' => $entityRegistry->specialization(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->int())
                ],
                'resolve' => function ($root, $args) {
                    return Specialization::find()->oneById($args['id']);
                }
            ],
        ];
    }


}