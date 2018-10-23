<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\QueryTypeInterface;
use api\graphql\core\TypeRegistry;
use api\models\lk\Salon;

/**
 * Class SalonType
 *
 * @package api\graphql\lk\types\entity
 */
class SalonType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'salons' => [
                'type' => $typeRegistry->listOff($entityRegistry->salon()),
                'description' => 'Коллекция салонов',
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
                    return Salon::find()
                        ->limit($args['limit'])
                        ->offset($args['offset'])
                        ->allByCurrentAccountId();
                }
            ],
            'salon' => [
                'type' => $entityRegistry->salon(),
                'description' => 'Салон',
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return Salon::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ],
        ];
    }


}