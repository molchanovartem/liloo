<?php

namespace api\graphql\lk\types\entity;

use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\lk\Recall;

/**
 * Class RecallType
 *
 * @package api\graphql\lk\types\entity
 */
class RecallType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'recalls' => [
                'type' => $typeRegistry->listOff($entityRegistry->recall()),
                'description' => 'Коллекция отзывов',
                'args' => [
                    'appointment_id' => [
                        'type' => $typeRegistry->int(),
                        'defaultValue' => null
                    ],
                ],
                'resolve' => function ($root, $args) {
                    return Recall::find()
                        ->byAppointmentId($args['appointment_id'])
                        ->allByCurrentAccountId();
                }
            ],
            'recall' => [
                'type' => $entityRegistry->recall(),
                'description' => 'Отзыв',
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return Recall::find()
                        ->byCurrentAccountId()
                        ->oneById($args['id']);
                }
            ],
        ];
    }
}
