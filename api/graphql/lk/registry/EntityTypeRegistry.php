<?php

namespace api\graphql\lk\registry;

use api\graphql\AdditionalTypeRegistry;
use api\graphql\lk\types\entity\AccountTariffType;
use api\graphql\lk\types\entity\AccountType;
use api\graphql\lk\types\entity\AppointmentItemType;
use api\graphql\lk\types\entity\AppointmentType;
use api\graphql\lk\types\entity\BalanceJournalType;
use api\graphql\common\types\entity\CityType;
use api\graphql\lk\types\entity\ClientType;
use api\graphql\lk\types\entity\ConvenienceType;
use api\graphql\common\types\entity\CountryType;
use api\graphql\lk\types\entity\MasterScheduleType;
use api\graphql\lk\types\entity\MasterServiceType;
use api\graphql\lk\types\entity\MasterType;
use api\graphql\lk\types\entity\RecallType;
use api\graphql\lk\types\entity\SalonServiceType;
use api\graphql\lk\types\entity\SalonType;
use api\graphql\lk\types\entity\SalonMasterType;
use api\graphql\lk\types\entity\ServiceGroupType;
use api\graphql\lk\types\entity\ServiceType;
use api\graphql\lk\types\entity\SpecializationType;
use api\graphql\lk\types\entity\TariffType;
use api\graphql\lk\types\entity\UserProfileType;
use api\graphql\lk\types\entity\UserScheduleType;
use api\graphql\lk\types\entity\UserType;
use api\graphql\lk\types\entity\MasterSpecializationType;
use api\graphql\lk\types\entity\TariffPriceType;

/**
 * Class EntityTypeRegistry
 *
 * @package api\schema\registry
 */
class EntityTypeRegistry extends AdditionalTypeRegistry
{
    public function account()
    {
        return $this->typeRegistry->get(AccountType::class);
    }

    public function country()
    {
        return $this->typeRegistry->get(CountryType::class);
    }

    public function city()
    {
        return $this->typeRegistry->get(CityType::class);
    }

    public function specialization()
    {
        return $this->typeRegistry->get(SpecializationType::class);
    }

    public function convenience()
    {
        return $this->typeRegistry->get(ConvenienceType::class);
    }

    public function user()
    {
        return $this->typeRegistry->get(UserType::class);
    }

    public function userProfile()
    {
        return $this->typeRegistry->get(UserProfileType::class);
    }

    public function userSchedule()
    {
        return $this->typeRegistry->get(UserScheduleType::class);
    }

    public function client()
    {
        return $this->typeRegistry->get(ClientType::class);
    }

    public function master()
    {
        return $this->typeRegistry->get(MasterType::class);
    }

    public function masterSchedule()
    {
        return $this->typeRegistry->get(MasterScheduleType::class);
    }

    public function masterService()
    {
        return $this->typeRegistry->get(MasterServiceType::class);
    }

    public function masterSpecialization()
    {
        return $this->typeRegistry->get(MasterSpecializationType::class);
    }

    public function service()
    {
        return $this->typeRegistry->get(ServiceType::class);
    }

    public function serviceGroup()
    {
        return $this->typeRegistry->get(ServiceGroupType::class);
    }

    public function appointment()
    {
        return $this->typeRegistry->get(AppointmentType::class);
    }

    public function appointmentItem()
    {
        return $this->typeRegistry->get(AppointmentItemType::class);
    }

    public function salon()
    {
        return $this->typeRegistry->get(SalonType::class);
    }

    public function salonService()
    {
        return $this->typeRegistry->get(SalonServiceType::class);
    }

    public function salonMaster()
    {
        return $this->typeRegistry->get(SalonMasterType::class);
    }

    public function recall()
    {
        return $this->typeRegistry->get(RecallType::class);
    }

    public function tariff()
    {
        return $this->typeRegistry->get(TariffType::class);
    }

    public function tariffPrice()
    {
        return $this->typeRegistry->get(TariffPriceType::class);
    }

    public function accountTariff()
    {
        return $this->typeRegistry->get(AccountTariffType::class);
    }

    public function balanceJournal()
    {
        return $this->typeRegistry->get(BalanceJournalType::class);
    }

    public function userLogin()
    {
        return $this->typeRegistry->get(UserLoginType::class);
    }
}