<?php

namespace api\schema\type\query;

use GraphQL\Type\Definition\ObjectType;
use api\models\Service;
use api\repositories\SpecializationRepository;
use api\schema\TypeRegistry;

/**
 * Class ServiceType
 *
 * @package api\schema\query
 */
class ServiceType extends ObjectType implements QueryTypeInterface
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $queryRegistry) {
                return [
                    'id' => $typeRegistry->int(),
                    'account_id' => $typeRegistry->int(),
                    'parent_id' => $typeRegistry->int(),
                    'specialization_id' => $typeRegistry->int(),
                    'name' => $typeRegistry->string(),
                    'price' => $typeRegistry->string(),
                    'duration' => $typeRegistry->int(),
                    'specialization' => [
                        'type' => $queryRegistry->specialization(),
                        'description' => 'Коллекция специализайий',
                        'resolve' => function (Service $service, $args, $context, $info) {
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
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'services' => [
                'type' => $typeRegistry->listOff($queryRegistry->service()),
                'description' => 'Коллекция услуг',
                'args' => [
                    'parent_id' => [
                        'type' => $typeRegistry->int(),
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
                    return Service::find()->allByParams($args['parent_id'], $args['limit'], $args['offset']);
                }
            ],
            'service' => [
                'type' => $queryRegistry->service(),
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->int())
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Service::find()->oneById($args['id']);
                }
            ],
        ];
    }


}