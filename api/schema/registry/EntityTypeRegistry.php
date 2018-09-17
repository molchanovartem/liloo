<?php

namespace api\schema\registry;

use api\schema\type\entity\AccountTariffType;
use api\schema\type\entity\AppointmentItemType;
use api\schema\type\entity\AppointmentType;
use api\schema\type\entity\BalanceJournalType;
use api\schema\type\entity\CityType;
use api\schema\type\entity\ClientType;
use api\schema\type\entity\ConvenienceType;
use api\schema\type\entity\CountryType;
use api\schema\type\entity\MasterScheduleType;
use api\schema\type\entity\MasterServiceType;
use api\schema\type\entity\MasterType;
use api\schema\type\entity\RecallType;
use api\schema\type\entity\SalonServiceType;
use api\schema\type\entity\SalonType;
use api\schema\type\entity\SalonMasterType;
use api\schema\type\entity\ServiceGroupType;
use api\schema\type\entity\ServiceType;
use api\schema\type\entity\SpecializationType;
use api\schema\type\entity\TariffType;
use api\schema\type\entity\UserProfileType;
use api\schema\type\entity\UserScheduleType;
use api\schema\type\entity\UserType;
use api\schema\type\entity\MasterSpecializationType;
use api\schema\type\entity\TariffPriceType;
use api\schema\type\mutation\user\login\UserLoginType;

/**
 * Class EntityTypeRegistry
 *
 * @package api\schema\registry
 */
class EntityTypeRegistry
{
    private $typeRegistry;

    public function __construct(TypeRegistry $typeRegistry)
    {
        $this->typeRegistry = $typeRegistry;
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