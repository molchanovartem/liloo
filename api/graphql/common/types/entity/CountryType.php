<?php

namespace api\graphql\common\types\entity;

use common\models\Country;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;

/**
 * Class CountryType
 *
 * @package api\graphql\common\types\entity
 */
class CountryType extends \api\graphql\base\types\entity\CountryType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'countries' => [
                'type' => $typeRegistry->listOff($entityRegistry->country()),
                'resolve' => function ($root, $args) {
                    return Country::find()->all();
                },
            ],
            'country' => [
                'type' => $entityRegistry->country(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return Country::find()->oneById($args['id']);
                }
            ]
        ];
    }
}