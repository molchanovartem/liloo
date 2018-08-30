<?php

namespace api\schema\type;

use api\schema\registry\TypeRegistry;
use api\schema\type\entity\AppointmentItemType;
use api\schema\type\entity\AppointmentType;
use api\schema\type\entity\CityType;
use api\schema\type\entity\ConvenienceType;
use api\schema\type\entity\CountryType;
use api\schema\type\entity\MasterScheduleType;
use api\schema\type\entity\MasterServiceType;
use api\schema\type\entity\MasterSpecializationType;
use api\schema\type\entity\MasterType;
use api\schema\type\entity\SalonMasterType;
use api\schema\type\entity\SalonServiceType;
use api\schema\type\entity\SalonType;
use api\schema\type\entity\ServiceGroupType;
use api\schema\type\entity\ServiceType;
use api\schema\type\entity\SpecializationType;
use api\schema\type\entity\UserProfileType;
use api\schema\type\entity\UserScheduleType;
use api\schema\type\entity\UserType;
use api\schema\type\entity\ClientType;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class QueryType
 *
 * @package api\schema\type
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
                    UserType::getFieldsQueryType($typeRegistry),
                    UserProfileType::getFieldsQueryType($typeRegistry),
                    UserScheduleType::getFieldsQueryType($typeRegistry),
                    ClientType::getFieldsQueryType($typeRegistry),
                    ServiceType::getFieldsQueryType($typeRegistry),
                    ServiceGroupType::getFieldsQueryType($typeRegistry),
                    AppointmentType::getFieldsQueryType($typeRegistry),
                    AppointmentItemType::getFieldsQueryType($typeRegistry),
                    SalonType::getFieldsQueryType($typeRegistry),
                    SalonServiceType::getFieldsQueryType($typeRegistry),
                    SalonMasterType::getFieldsQueryType($typeRegistry),
                    MasterType::getFieldsQueryType($typeRegistry),
                    MasterScheduleType::getFieldsQueryType($typeRegistry),
                    MasterServiceType::getFieldsQueryType($typeRegistry),
                    MasterSpecializationType::getFieldsQueryType($typeRegistry)
                    /*
                    UserType::getFieldsQueryType($typeRegistry),
                    UserScheduleType::getFieldsQueryType($typeRegistry),
                    SpecializationType::getFieldsQueryType($typeRegistry),
                    ConvenienceType::getFieldsQueryType($typeRegistry),
                    ClientType::getFieldsQueryType($typeRegistry),
                    ServiceType::getFieldsQueryType($typeRegistry),
                    ServiceGroupType::getFieldsQueryType($typeRegistry),
                    SalonType::getFieldsQueryType($typeRegistry),
                    SalonUserServiceType::getFieldsQueryType($typeRegistry),
                    AppointmentType::getFieldsQueryType($typeRegistry)
                    */
                );
            }
        ]);
    }
}