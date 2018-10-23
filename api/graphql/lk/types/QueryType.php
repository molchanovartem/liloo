<?php

namespace api\graphql\lk\types;

use api\graphql\lk\types\entity\AccountType;
use GraphQL\Type\Definition\ObjectType;
use api\graphql\core\TypeRegistry;
use api\graphql\lk\types\entity\AccountTariffType;
use api\graphql\lk\types\entity\AppointmentItemType;
use api\graphql\lk\types\entity\AppointmentType;
use api\graphql\lk\types\entity\BalanceJournalType;
use api\graphql\common\types\entity\CityType;
use api\graphql\lk\types\entity\ConvenienceType;
use api\graphql\common\types\entity\CountryType;
use api\graphql\lk\types\entity\MasterScheduleType;
use api\graphql\lk\types\entity\MasterServiceType;
use api\graphql\lk\types\entity\MasterSpecializationType;
use api\graphql\lk\types\entity\MasterType;
use api\graphql\lk\types\entity\RecallType;
use api\graphql\lk\types\entity\SalonMasterType;
use api\graphql\lk\types\entity\SalonServiceType;
use api\graphql\lk\types\entity\SalonType;
use api\graphql\lk\types\entity\ServiceType;
use api\graphql\lk\types\entity\SpecializationType;
use api\graphql\lk\types\entity\TariffPriceType;
use api\graphql\lk\types\entity\TariffType;
use api\graphql\lk\types\entity\UserProfileType;
use api\graphql\lk\types\entity\UserScheduleType;
use api\graphql\lk\types\entity\UserType;
use api\graphql\lk\types\entity\ClientType;

/**
 * Class QueryType
 *
 * @package api\graphql\lk\types
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
                    AccountType::getFieldsQueryType($typeRegistry),
                    AccountTariffType::getFieldsQueryType($typeRegistry),
                    BalanceJournalType::getFieldsQueryType($typeRegistry),
                    CountryType::getFieldsQueryType($typeRegistry),
                    CityType::getFieldsQueryType($typeRegistry),
                    SpecializationType::getFieldsQueryType($typeRegistry),
                    ConvenienceType::getFieldsQueryType($typeRegistry),
                    UserType::getFieldsQueryType($typeRegistry),
                    UserProfileType::getFieldsQueryType($typeRegistry),
                    UserScheduleType::getFieldsQueryType($typeRegistry),
                    ClientType::getFieldsQueryType($typeRegistry),
                    ServiceType::getFieldsQueryType($typeRegistry),
                    AppointmentType::getFieldsQueryType($typeRegistry),
                    AppointmentItemType::getFieldsQueryType($typeRegistry),
                    SalonType::getFieldsQueryType($typeRegistry),
                    SalonServiceType::getFieldsQueryType($typeRegistry),
                    SalonMasterType::getFieldsQueryType($typeRegistry),
                    MasterType::getFieldsQueryType($typeRegistry),
                    MasterScheduleType::getFieldsQueryType($typeRegistry),
                    MasterServiceType::getFieldsQueryType($typeRegistry),
                    MasterSpecializationType::getFieldsQueryType($typeRegistry),
                    RecallType::getFieldsQueryType($typeRegistry),
                    TariffType::getFieldsQueryType($typeRegistry),
                    TariffPriceType::getFieldsQueryType($typeRegistry)
                );
            }
        ]);
    }
}