<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\QueryTypeInterface;
use api\graphql\TypeRegistry;
use api\models\MasterSpecialization;

/**
 * Class MasterSpecializationType
 *
 * @package api\graphql\lk\types\entity
 */
class MasterSpecializationType extends ObjectType implements QueryTypeInterface
{
    /**
     * MasterSpecializationType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'specialization_id' => $typeRegistry->id()
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
            'masterSpecializations' => [
                'type' => $typeRegistry->listOff($entityRegistry->masterSpecialization()),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return MasterSpecialization::find()->allByMasterId($args['master_id']);
                }
            ]
        ];
    }
}