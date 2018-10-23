<?php

namespace api\graphql\common\types\entity;

use common\models\Tariff;
use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;

/**
 * Class TariffType
 *
 * @package api\graphql\common\types\entity
 */
class TariffType extends \api\graphql\base\types\entity\TariffType implements QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'tariffs' => [
                'type' => $typeRegistry->listOff($entityRegistry->tariff()),
                'description' => 'Коллекция тарифов',
                'resolve' => function ($root, $args) {
                    return Tariff::find()->all();
                }
            ],
            'tariff' => [
                'type' => $entityRegistry->tariff(),
                'description' => 'Тариф',
                'args' => [
                    'id' => [
                        'type' => $typeRegistry->nonNull($typeRegistry->id()),
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return Tariff::find()->byId($args['id'])->one();
                }
            ],
        ];
    }
}