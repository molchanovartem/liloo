<?php

namespace api\schema\type\entity;

use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use common\models\Country;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class CountryType
 *
 * @package api\schema\type\entity
 */
class CountryType extends ObjectType implements QueryTypeInterface
{
    /**
     * CountryType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'name' => $typeRegistry->string(),
                    'currency_code' => $typeRegistry->int(),
                    'currency_string_code' => $typeRegistry->string(),
                    'phone_code' => $typeRegistry->int()
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