<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\Service;

/**
 * Class ServiceType
 *
 * @package api\graphql\lk\types\entity
 */
class ServiceType extends ObjectType implements QueryTypeInterface
{
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
                    'specialization' => [
                        'type' => $entityRegistry->specialization(),
                        'description' => 'Коллекция специализайий',
                        'resolve' => function (Service $service, $args, $context, $info) {
                    /*
                     * @todo
                     */
                            $repository = SpecializationRepository::getInstance();
                            return $repository->findByIdFromAll($service['specialization_id']);
                        }
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
            'services' => [
                'type' => $typeRegistry->listOff($entityRegistry->service()),
                'description' => 'Коллекция услуг',
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
                'resolve' => function ($root, $args) {
                    return Service::find()->allServiceByParams($args['parent_id'], $args['limit'], $args['offset']);
                }
            ],
            'service' => [
                'type' => $entityRegistry->service(),
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