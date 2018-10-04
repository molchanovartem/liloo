<?php

namespace api\graphql\common\types\entity;

use common\models\Specialization;
use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;

/**
 * Class SpecializationType
 *
 * @package api\graphql\common\types\entity
 */
class SpecializationType extends \api\graphql\base\types\entity\SpecializationType implements QueryTypeInterface
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
                    return Specialization::find()->allByParams($args['limit'], $args['offset']);
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