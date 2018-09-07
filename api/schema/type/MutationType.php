<?php

namespace api\schema\type;

use api\schema\type\mutation\appointment\AppointmentType;
use api\schema\type\mutation\appointment\item\AppointmentItemType;
use api\schema\type\mutation\client\ClientType;
use api\schema\type\mutation\convenience\ConvenienceType;
use api\schema\type\mutation\master\MasterServiceType;
use api\schema\type\mutation\master\MasterSpecializationType;
use api\schema\type\mutation\master\MasterType;
use api\schema\type\mutation\master\schedule\MasterScheduleType;
use api\schema\type\mutation\salon\SalonConvenienceType;
use api\schema\type\mutation\salon\SalonMasterType;
use api\schema\type\mutation\salon\SalonSpecializationType;
use api\schema\type\mutation\salon\SalonType;
use api\schema\type\mutation\salon\service\SalonServiceType;
use api\schema\type\mutation\service\ServiceType;
use api\schema\type\mutation\serviceGroup\ServiceGroupType;
use api\schema\type\mutation\user\UserConvenienceType;
use api\schema\type\mutation\specialization\SpecializationType;
use api\schema\registry\TypeRegistry;
use api\schema\type\mutation\user\profile\UserProfileType;
use api\schema\type\mutation\user\schedule\UserScheduleType;
use api\schema\type\mutation\user\UserSpecializationType;
use api\schema\type\mutation\user\UserType;
use GraphQL\Type\Definition\ObjectType;
use api\schema\type\mutation\recall\RecallType;

/**
 * Class MutationType
 * @package api\schema\type
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
                    SpecializationType::getMutationFieldsType($typeRegistry),
                    ConvenienceType::getMutationFieldsType($typeRegistry),
                    UserType::getMutationFieldsType($typeRegistry),
                    UserProfileType::getMutationFieldsType($typeRegistry),
                    UserSpecializationType::getMutationFieldsType($typeRegistry),
                    UserConvenienceType::getMutationFieldsType($typeRegistry),
                    UserScheduleType::getMutationFieldsType($typeRegistry),
                    ClientType::getMutationFieldsType($typeRegistry),
                    ServiceType::getMutationFieldsType($typeRegistry),
                    ServiceGroupType::getMutationFieldsType($typeRegistry),
                    AppointmentType::getMutationFieldsType($typeRegistry),
                    AppointmentItemType::getMutationFieldsType($typeRegistry),
                    SalonType::getMutationFieldsType($typeRegistry),
                    SalonSpecializationType::getMutationFieldsType($typeRegistry),
                    SalonConvenienceType::getMutationFieldsType($typeRegistry),
                    SalonServiceType::getMutationFieldsType($typeRegistry),
                    SalonMasterType::getMutationFieldsType($typeRegistry),
                    MasterType::getMutationFieldsType($typeRegistry),
                    MasterSpecializationType::getMutationFieldsType($typeRegistry),
                    MasterScheduleType::getMutationFieldsType($typeRegistry),
                    MasterServiceType::getMutationFieldsType($typeRegistry),
                    RecallType::getMutationFieldsType($typeRegistry)
                );
            }
        ]);
    }
}
