<?php

namespace api\schema\type\entity;

use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use common\models\City;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class CityType
 *
 * @package api\schema\type\entity
 */
class CityType extends ObjectType implements QueryTypeInterface
{
    /**
     * CityType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'country_id' => $typeRegistry->id(),
                    'name' => $typeRegistry->string(),
                    'phone_code' => $typeRegistry->string()
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
            'cities' => [
                'type' => $typeRegistry->listOff($entityRegistry->city()),
                'args' => [
                    'country_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return City::find()->allByCountryId($args['country_id']);
                }
            ],
            'city' => [
                'type' => $entityRegistry->city(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return City::find()->oneById($args['id']);
                }
            ]
        ];
    }

}