<?php

namespace api\schema\type\entity;

use api\models\Master;
use api\models\SalonMaster;
use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class SalonMasterType
 *
 * @package api\schema\type\entity
 */
class SalonMasterType extends ObjectType implements QueryTypeInterface
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $entityRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
                    'master_id' => $typeRegistry->id(),
                    'master' => [
                        'type' => $entityRegistry->master(),
                        'resolve' => function (SalonMaster $model, $args) {
                            return Master::find()->oneById($model->master_id);
                        }
                    ]
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
            'salonMasters' => [
                'type' => $typeRegistry->listOff($entityRegistry->salonMaster()),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                ],
                'resolve' => function ($root, $args) {
                    return SalonMaster::find()->allBySalonId($args['salon_id']);
                }
            ]
        ];
    }
}