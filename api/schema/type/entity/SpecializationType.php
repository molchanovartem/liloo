<?php

namespace api\schema\type\entity;

use api\models\Specialization;
use api\schema\type\QueryTypeInterface;
use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class SpecializationType
 *
 * @package api\schema\type\entity
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
        $entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry) {
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
        ]);
    }

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