<?php

namespace api\graphql\base;

use api\graphql\core\AdditionalTypeRegistry;
use api\graphql\base\types\entity\AccountTariffType;
use api\graphql\base\types\entity\AccountType;
use api\graphql\base\types\entity\AppointmentItemType;
use api\graphql\base\types\entity\AppointmentType;
use api\graphql\base\types\entity\BalanceJournalType;
use api\graphql\base\types\entity\CityType;
use api\graphql\base\types\entity\ClientType;
use api\graphql\base\types\entity\CommonServiceType;
use api\graphql\base\types\entity\ConvenienceType;
use api\graphql\base\types\entity\CountryType;
use api\graphql\base\types\entity\MasterScheduleType;
use api\graphql\base\types\entity\MasterServiceType;
use api\graphql\base\types\entity\MasterSpecializationType;
use api\graphql\base\types\entity\MasterType;
use api\graphql\base\types\entity\RecallType;
use api\graphql\base\types\entity\SalonMasterType;
use api\graphql\base\types\entity\SalonServiceType;
use api\graphql\base\types\entity\SalonType;
use api\graphql\base\types\entity\ServiceType;
use api\graphql\base\types\entity\SpecializationType;
use api\graphql\base\types\entity\TariffPriceType;
use api\graphql\base\types\entity\TariffType;
use api\graphql\base\types\entity\UserProfileType;
use api\graphql\base\types\entity\UserScheduleType;
use api\graphql\base\types\entity\UserType;

/**
 * Class EntityTypeRegistry
 *
 * @package api\graphql\base
 */
class EntityTypeRegistry extends AdditionalTypeRegistry
{
    public function account()
    {
        return $this->typeRegistry->get(AccountType::class);
    }

    public function accountTariff()
    {
        return $this->typeRegistry->get(AccountTariffType::class);
    }

    public function city()
    {
        return $this->typeRegistry->get(CityType::class);
    }

    public function country()
    {
        return $this->typeRegistry->get(CountryType::class);
    }

    public function specialization()
    {
        return $this->typeRegistry->get(SpecializationType::class);
    }

    public function convenience()
    {
        return $this->typeRegistry->get(ConvenienceType::class);
    }

    public function commonService()
    {
        return $this->typeRegistry->get(CommonServiceType::class);
    }

    public function tariff()
    {
        return $this->typeRegistry->get(TariffType::class);
    }

    public function tariffPrice()
    {
        return $this->typeRegistry->get(TariffPriceType::class);
    }

    public function balanceJournal()
    {
        return $this->typeRegistry->get(BalanceJournalType::class);
    }

    public function client()
    {
        return $this->typeRegistry->get(ClientType::class);
    }

    public function recall()
    {
        return $this->typeRegistry->get(RecallType::class);
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

    public function appointmentItem()
    {
        return $this->typeRegistry->get(AppointmentItemType::class);
    }

    public function appointment()
    {
        return $this->typeRegistry->get(AppointmentType::class);
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

    public function master()
    {
        return $this->typeRegistry->get(MasterType::class);
    }

    public function service()
    {
        return $this->typeRegistry->get(ServiceType::class);
    }

    public function salon()
    {
        return $this->typeRegistry->get(SalonType::class);
    }

    public function salonMaster()
    {
        return $this->typeRegistry->get(SalonMasterType::class);
    }

    public function salonService()
    {
        return $this->typeRegistry->get(SalonServiceType::class);
    }
}