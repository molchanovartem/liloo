<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use common\models\City;

/**
 * Class CityType
 *
 * @package api\graphql\lk\types\entity
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