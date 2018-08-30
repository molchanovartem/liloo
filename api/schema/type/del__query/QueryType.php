<?php

namespace api\schema\type\query;

use api\schema\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return array_merge(
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
                );
            }
        ]);
    }
}