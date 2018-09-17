<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\Master;
use api\models\SalonMaster;

/**
 * Class SalonMasterType
 *
 * @package api\graphql\lk\types\entity
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