<?php

namespace api\graphql\common\types;

use api\graphql\common\types\entity\FreeTimeType;
use api\graphql\common\types\entity\MasterType;
use api\graphql\common\types\entity\ServiceType;
use GraphQL\Type\Definition\ObjectType;
use api\graphql\common\types\entity\CommonServiceType;
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
                    TariffPriceType::getFieldsQueryType($typeRegistry),
                    MasterType::getFieldsQueryType($typeRegistry),
                    ServiceType::getFieldsQueryType($typeRegistry),
                    FreeTimeType::getFieldsQueryType($typeRegistry)
                );
            }
        ]);
    }
}