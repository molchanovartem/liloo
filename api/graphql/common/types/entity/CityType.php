<?php

namespace api\graphql\common\types\entity;

use common\models\City;
use api\graphql\core\QueryTypeInterface;
use api\graphql\core\TypeRegistry;

/**
 * Class CityType
 *
 * @package api\graphql\common\types\entity
 */
class CityType extends \api\graphql\base\types\entity\CityType implements QueryTypeInterface
{
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