<?php

namespace api\schema\type\entity;

use api\models\Master;
use GraphQL\Type\Definition\ObjectType;
use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;

/**
 * Class MasterType
 *
 * @package api\schema\type\entity
 */
class MasterType extends ObjectType implements QueryTypeInterface
{
    /**
     * MasterType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'user_id' => $typeRegistry->id(),
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date()
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
            'masters' => [
                'type' => $typeRegistry->listOff($entityRegistry->master()),
                'description' => 'Коллекция мастеров',
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
                    return Master::find()->allByCurrentAccountId();
                }
            ],
            'master' => [
                'type' => $entityRegistry->master(),
                'description' => 'Мастер',
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id()),
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Master::find()->oneById($args['id']);
                }
            ],
        ];
    }
}