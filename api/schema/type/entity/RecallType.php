<?php

namespace api\schema\type\entity;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;
use api\schema\type\QueryTypeInterface;
use api\models\Recall;

/**
 * Class RecallType
 * @package api\schema\type\entity
 */
class RecallType extends ObjectType implements QueryTypeInterface
{
    /**
     * RecallType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        $config = [
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'author_id' => $typeRegistry->id(),
                    'appointment_id' => $typeRegistry->id(),
                    'parent_id' => $typeRegistry->id(),
                    'text' => $typeRegistry->string(),
                    'assessment' => $typeRegistry->int(),
                    'type' => $typeRegistry->int(),
                    'create_time' => $typeRegistry->dateTime(),
                    'response' => [
                        'type' => $entityRegistry->recall(),
                        'description' => 'Ответ',
                        'resolve' => function (Recall $recall, $args, $context, $info) {
                            return Recall::find()
                                ->where(['parent_id' => $recall->id])
                                ->one();
                        }
                    ],
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
                    return Recall::find()->allByParams($args['appointment_id']);
                }
            ],
            'recall' => [
                'type' => $entityRegistry->recall(),
                'description' => 'Отзыв',
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return Recall::find()->oneById($args['id']);
                }
            ],
        ];
    }
}
