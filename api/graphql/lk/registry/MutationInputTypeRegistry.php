<?php

namespace api\graphql\lk\registry;

use api\graphql\AdditionalTypeRegistry;
use api\graphql\lk\types\mutation\appointment\AppointmentCreateInputType;
use api\graphql\lk\types\mutation\appointment\AppointmentUpdateInputType;
use api\graphql\lk\types\mutation\client\ClientCreateInputType;
use api\graphql\lk\types\mutation\client\ClientUpdateInputType;
use api\graphql\lk\types\mutation\convenience\ConvenienceCreateInputType;
use api\graphql\lk\types\mutation\convenience\ConvenienceUpdateInputType;
use api\graphql\lk\types\mutation\appointment\item\AppointmentItemCreateInputType;
use api\graphql\lk\types\mutation\master\MasterCreateInputType;
use api\graphql\lk\types\mutation\master\MasterUpdateInputType;
use api\graphql\lk\types\mutation\master\schedule\MasterScheduleCreateInputType;
use api\graphql\lk\types\mutation\master\schedule\MasterScheduleUpdateInputType;
use api\graphql\lk\types\mutation\recall\RecallCreateInputType;
use api\graphql\lk\types\mutation\recall\RecallResponseCreateInputType;
use api\graphql\lk\types\mutation\salon\SalonCreateInputType;
use api\graphql\lk\types\mutation\salon\SalonUpdateInputType;
use api\graphql\lk\types\mutation\salon\service\SalonServiceCreateInputType;
use api\graphql\lk\types\mutation\salon\service\SalonServiceUpdateInputType;
use api\graphql\lk\types\mutation\salon\service\SalonServiceUpdateItemsInputType;
use api\graphql\lk\types\mutation\service\ServiceCreateInputType;
use api\graphql\lk\types\mutation\service\ServiceUpdateInputType;
use api\graphql\lk\types\mutation\serviceGroup\ServiceGroupCreateInputType;
use api\graphql\lk\types\mutation\serviceGroup\ServiceGroupUpdateInputType;
use api\graphql\lk\types\mutation\user\schedule\UserScheduleCreateInputType;
use api\graphql\lk\types\mutation\user\schedule\UserScheduleUpdateInputType;
use api\graphql\lk\types\mutation\user\UserCreateInputType;
use api\graphql\lk\types\mutation\user\UserCreateProfileInputType;
use api\graphql\lk\types\mutation\user\profile\UserProfileUpdateInputType;
use api\graphql\lk\types\mutation\user\UserUpdateInputType;
use api\graphql\lk\types\mutation\specialization\SpecializationCreateInputType;
use api\graphql\lk\types\mutation\specialization\SpecializationUpdateInputType;

/**
 * Class TypeMutationInputRegistry
 *
 * @package api\schema
 */
class MutationInputTypeRegistry extends AdditionalTypeRegistry
{
    public function specializationCreate()
    {
        return $this->typeRegistry->get(SpecializationCreateInputType::class);
    }

    public function specializationUpdate()
    {
        return $this->typeRegistry->get(SpecializationUpdateInputType::class);
    }

    public function convenienceCreate()
    {
        return $this->typeRegistry->get(ConvenienceCreateInputType::class);
    }

    public function convenienceUpdate()
    {
        return $this->typeRegistry->get(ConvenienceUpdateInputType::class);
    }

    public function userCreate()
    {
        return $this->typeRegistry->get(UserCreateInputType::class);
    }

    public function userUpdate()
    {
        return $this->typeRegistry->get(UserUpdateInputType::class);
    }

    public function userCreateProfile()
    {
        return $this->typeRegistry->get(UserCreateProfileInputType::class);
    }

    public function userProfileUpdate()
    {
        return $this->typeRegistry->get(UserProfileUpdateInputType::class);
    }

    public function userScheduleCreate()
    {
        return $this->typeRegistry->get(UserScheduleCreateInputType::class);
    }

    public function userScheduleUpdate()
    {
        return $this->typeRegistry->get(UserScheduleUpdateInputType::class);
    }

    public function clientCreate()
    {
        return $this->typeRegistry->get(ClientCreateInputType::class);
    }

    public function clientUpdate()
    {
        return $this->typeRegistry->get(ClientUpdateInputType::class);
    }

    public function masterCreate()
    {
        return $this->typeRegistry->get(MasterCreateInputType::class);
    }

    public function masterUpdate()
    {
        return $this->typeRegistry->get(MasterUpdateInputType::class);
    }

    public function masterScheduleCreate()
    {
        return $this->typeRegistry->get(MasterScheduleCreateInputType::class);
    }

    public function masterScheduleUpdate()
    {
        return $this->typeRegistry->get(MasterScheduleUpdateInputType::class);
    }

    public function serviceCreate()
    {
        return $this->typeRegistry->get(ServiceCreateInputType::class);
    }

    public function serviceUpdate()
    {
        return $this->typeRegistry->get(ServiceUpdateInputType::class);
    }

    public function serviceGroupCreate()
    {
        return $this->typeRegistry->get(ServiceGroupCreateInputType::class);
    }

    public function serviceGroupUpdate()
    {
        return $this->typeRegistry->get(ServiceGroupUpdateInputType::class);
    }

    public function appointmentCreate()
    {
        return $this->typeRegistry->get(AppointmentCreateInputType::class);
    }

    public function appointmentUpdate()
    {
        return $this->typeRegistry->get(AppointmentUpdateInputType::class);
    }

    public function appointmentItemCreate()
    {
        return $this->typeRegistry->get(AppointmentItemCreateInputType::class);
    }

    public function salonCreate()
    {
        return $this->typeRegistry->get(SalonCreateInputType::class);
    }

    public  function salonUpdate()
    {
        return $this->typeRegistry->get(SalonUpdateInputType::class);
    }

    public function salonServiceCreate()
    {
        return $this->typeRegistry->get(SalonServiceCreateInputType::class);
    }

    public function salonServiceUpdate()
    {
        return $this->typeRegistry->get(SalonServiceUpdateInputType::class);
    }

    public function salonServiceUpdateItems()
    {
        return $this->typeRegistry->get(SalonServiceUpdateItemsInputType::class);
    }

    public function recallCreate()
    {
        return $this->typeRegistry->get(RecallCreateInputType::class);
    }

    public function recallResponseCreate()
    {
        return $this->typeRegistry->get(RecallResponseCreateInputType::class);
    }
}
