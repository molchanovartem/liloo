<?php

namespace api\graphql\common\types;

use api\graphql\common\types\entity\CommonServiceType;
use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\common\types\entity\CityType;
use api\graphql\common\types\entity\ConvenienceType;
use api\graphql\common\types\entity\CountryType;
use api\graphql\common\types\entity\SpecializationType;
use api\graphql\common\types\entity\TariffPriceType;
use api\graphql\common\types\entity\TariffType;

/**
 * Class QueryType
 *
 * @package api\graphql\common\types
 */
class QueryType extends ObjectType
{
    /**
     * QueryType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return array_merge(
                    CountryType::getFieldsQueryType($typeRegistry),
                    CityType::getFieldsQueryType($typeRegistry),
                    SpecializationType::getFieldsQueryType($typeRegistry),
                    ConvenienceType::getFieldsQueryType($typeRegistry),
                    CommonServiceType::getFieldsQueryType($typeRegistry),
                    TariffType::getFieldsQueryType($typeRegistry),
                    TariffPriceType::getFieldsQueryType($typeRegistry)
                );
            }
        ]);
    }
}