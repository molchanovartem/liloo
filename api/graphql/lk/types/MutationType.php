<?php

namespace api\graphql\lk\types;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\core\TypeRegistry;
use api\graphql\lk\types\mutation\balance\BalanceType;
use api\graphql\lk\types\mutation\appointment\AppointmentType;
use api\graphql\lk\types\mutation\client\ClientType;
use api\graphql\lk\types\mutation\convenience\ConvenienceType;
use api\graphql\lk\types\mutation\master\MasterServiceType;
use api\graphql\lk\types\mutation\master\MasterSpecializationType;
use api\graphql\lk\types\mutation\master\MasterType;
use api\graphql\lk\types\mutation\master\schedule\MasterScheduleType;
use api\graphql\lk\types\mutation\salon\SalonConvenienceType;
use api\graphql\lk\types\mutation\salon\SalonMasterType;
use api\graphql\lk\types\mutation\salon\SalonSpecializationType;
use api\graphql\lk\types\mutation\salon\SalonType;
use api\graphql\lk\types\mutation\salon\service\SalonServiceType;
use api\graphql\lk\types\mutation\service\ServiceType;
use api\graphql\lk\types\mutation\tariff\TariffType;
use api\graphql\lk\types\mutation\user\UserConvenienceType;
use api\graphql\lk\types\mutation\specialization\SpecializationType;
use api\graphql\lk\types\mutation\user\profile\UserProfileType;
use api\graphql\lk\types\mutation\user\schedule\UserScheduleType;
use api\graphql\lk\types\mutation\user\UserSpecializationType;
use api\graphql\lk\types\mutation\user\UserType;
use api\graphql\lk\types\mutation\recall\RecallType;

/**
 * Class MutationType
 *
 * @package api\graphql\lk\types
 */
class MutationType extends ObjectType
{
    /**
     * MutationType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return array_merge(
                    BalanceType::getMutationFieldsType($typeRegistry),
                    SpecializationType::getMutationFieldsType($typeRegistry),
                    ConvenienceType::getMutationFieldsType($typeRegistry),
                    UserType::getMutationFieldsType($typeRegistry),
                    UserProfileType::getMutationFieldsType($typeRegistry),
                    UserSpecializationType::getMutationFieldsType($typeRegistry),
                    UserConvenienceType::getMutationFieldsType($typeRegistry),
                    UserScheduleType::getMutationFieldsType($typeRegistry),
                    ClientType::getMutationFieldsType($typeRegistry),
                    ServiceType::getMutationFieldsType($typeRegistry),
                    //ServiceGroupType::getMutationFieldsType($typeRegistry),
                    AppointmentType::getMutationFieldsType($typeRegistry),
                    //AppointmentItemType::getMutationFieldsType($typeRegistry),
                    SalonType::getMutationFieldsType($typeRegistry),
                    SalonSpecializationType::getMutationFieldsType($typeRegistry),
                    SalonConvenienceType::getMutationFieldsType($typeRegistry),
                    SalonServiceType::getMutationFieldsType($typeRegistry),
                    SalonMasterType::getMutationFieldsType($typeRegistry),
                    MasterType::getMutationFieldsType($typeRegistry),
                    MasterSpecializationType::getMutationFieldsType($typeRegistry),
                    MasterScheduleType::getMutationFieldsType($typeRegistry),
                    MasterServiceType::getMutationFieldsType($typeRegistry),
                    RecallType::getMutationFieldsType($typeRegistry),
                    TariffType::getMutationFieldsType($typeRegistry)
                );
            }
        ]);
    }
}
