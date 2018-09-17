<?php

namespace api\schema\registry;

use api\schema\type\mutation\appointment\AppointmentCreateInputType;
use api\schema\type\mutation\appointment\AppointmentUpdateInputType;
use api\schema\type\mutation\client\ClientCreateInputType;
use api\schema\type\mutation\client\ClientUpdateInputType;
use api\schema\type\mutation\convenience\ConvenienceCreateInputType;
use api\schema\type\mutation\convenience\ConvenienceUpdateInputType;
use api\schema\type\mutation\item\AppointmentCreateItemType;
use api\schema\type\mutation\appointment\item\AppointmentItemCreateInputType;
use api\schema\type\mutation\appointment\item\AppointmentItemUpdateType;
use api\schema\type\mutation\master\MasterCreateInputType;
use api\schema\type\mutation\master\MasterUpdateInputType;
use api\schema\type\mutation\master\schedule\MasterScheduleCreateInputType;
use api\schema\type\mutation\master\schedule\MasterScheduleUpdateInputType;
use api\schema\type\mutation\recall\RecallCreateInputType;
use api\schema\type\mutation\recall\RecallResponseCreateInputType;
use api\schema\type\mutation\salon\SalonCreateInputType;
use api\schema\type\mutation\salon\SalonUpdateInputType;
use api\schema\type\mutation\salon\service\SalonServiceCreateInputType;
use api\schema\type\mutation\salon\service\SalonServiceUpdateInputType;
use api\schema\type\mutation\salon\service\SalonServiceUpdateItemsInputType;
use api\schema\type\mutation\service\ServiceCreateInputType;
use api\schema\type\mutation\service\ServiceUpdateInputType;
use api\schema\type\mutation\serviceGroup\ServiceGroupCreateInputType;
use api\schema\type\mutation\serviceGroup\ServiceGroupUpdateInputType;
use api\schema\type\mutation\tariff\AccountTariffCreateInputType;
use api\schema\type\mutation\user\login\UserFormLoginType;
use api\schema\type\mutation\user\schedule\UserScheduleCreateInputType;
use api\schema\type\mutation\user\schedule\UserScheduleUpdateInputType;
use api\schema\type\mutation\user\UserCreateInputType;
use api\schema\type\mutation\user\UserCreateProfileInputType;
use api\schema\type\mutation\user\profile\UserProfileUpdateInputType;
use api\schema\type\mutation\user\UserUpdateInputType;
use api\schema\type\mutation\specialization\SpecializationCreateInputType;
use api\schema\type\mutation\specialization\SpecializationUpdateInputType;

/**
 * Class TypeMutationInputRegistry
 *
 * @package api\schema
 */
class MutationInputTypeRegistry
{
    private $typeRegistry;

    public function __construct(TypeRegistry $typeRegistry)
    {
        $this->typeRegistry = $typeRegistry;
    }

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

    public function accountTariffCreate()
    {
        return $this->typeRegistry->get(AccountTariffCreateInputType::class);
    }

    public function userLogin()
    {
        return $this->typeRegistry->get(UserFormLoginType::class);
    }
}
