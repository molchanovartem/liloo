<?php

namespace api\schema\type\entity;

use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use GraphQL\Type\Definition\ObjectType;

class UserLoginType extends ObjectType implements QueryTypeInterface
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
                    'user_id' => $typeRegistry->id(),
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

        parent::__construct($typeRegistry);
    }

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        // TODO: Implement getFieldsQueryType() method.
    }
}