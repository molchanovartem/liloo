<?php

namespace api\graphql\site\types\entity;

use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\SalonService;
use api\models\site\Service;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class ServiceType
 * @package api\graphql\site\types\entity
 */
class ServiceType extends ObjectType implements QueryTypeInterface
{
    /**
     * QueryTypeInterface constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'parent_id' => $typeRegistry->id(),
                    'specialization_id' => $typeRegistry->id(),
                    'name' => $typeRegistry->string(),
                    'price' => $typeRegistry->string(),
                    'duration' => $typeRegistry->int(),
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
            'serviceByAccountId' => [
                'type' => $typeRegistry->listOff($entityRegistry->service()),
                'description' => 'Сервисы этого мастера',
                'args' => [
                    'account_id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id())
                    ],
                    'salon_id' => [
                        'type' => $typeRegistry->id(),
                        'defaultValue' => null,
                    ],
                ],
                'resolve' => function ($root, $args) {
                    if (empty($args['salon_id'])) {
                        return Service::find()->byAccountId($args['account_id'])->all();
                    }

                    return Service::find()
                        ->alias('s')
                        ->leftJoin(SalonService::tableName() . ' ss', 's.id = ss.service_id')
                        ->where(['ss.salon_id' => $args['salon_id']])
                        ->andWhere(['s.account_id' => $args['account_id']])
                        ->all();
                }
            ],
        ];
    }
}