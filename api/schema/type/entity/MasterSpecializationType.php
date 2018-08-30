<?php

namespace api\schema\type\entity;

use api\models\MasterSpecialization;
use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class MasterSpecializationType
 *
 * @package api\schema\type\entity
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