<?php

namespace api\repositories;

use yii\helpers\ArrayHelper;
use common\models\SalonConvenience;
use common\models\UserService;
use common\models\SalonSpecialization;
use common\models\SalonUser;
use api\models\Salon;
use api\core\db\Query;

/**
 * Class SalonRepository
 * @package api\repositories
 */
class SalonRepository extends Repository
{
    protected static $instance;

    /**
     * @var array
     */
    protected $allData = [];
    protected $specializations = [];
    protected $conveniences = [];
    protected $users = [];
    protected $services = [];

    /**
     * @return array
     */
    public function getAll(): array
    {
        if ($this->allData) return $this->allData;

        return $this->allData = Salon::find()
            ->indexBy('id')
            ->all();
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function findByIdFromAll(int $id)
    {
        return $this->getAll()[$id] ?? null;
    }

    /**
     * @param int $salonId
     * @return array
     */
    public function getSpecializations(int $salonId): array
    {
        if ($this->specializations) {
            return $this->specializations[$salonId] ?? [];
        }

        $salonsSpecializations = (new Query())->from(SalonSpecialization::tableName())
            ->isAccount()
            ->all();

        $specializationRepository = SpecializationRepository::getInstance();

        foreach ($salonsSpecializations as &$ss) {
            if (empty($this->specializations[$ss['salon_id']])) $this->specializations[$ss['salon_id']] = [];

            if ($specialization = $specializationRepository->findByIdFromAll($ss['specialization_id'])) {
                array_push($this->specializations[$ss['salon_id']], $specialization);
            }
        }

        return $this->specializations[$salonId] ?? [];
    }

    /**
     * @param int $salonId
     * @return array
     */
    public function getConveniences(int $salonId): array
    {
        if ($this->conveniences === null) return [];

        if ($this->conveniences) return $this->conveniences[$salonId] ?? [];

        $salonsConveniences = (new Query())->from(SalonConvenience::tableName())
            ->isAccount()
            ->all();

        if (!$salonsConveniences) $this->conveniences = null;

        $convenienceRepository = ConvenienceRepository::getInstance();

        foreach ($salonsConveniences as &$sc) {
            if (empty($this->conveniences[$sc['salon_id']])) $this->conveniences[$sc['salon_id']] = [];

            if ($convenience = $convenienceRepository->findByIdFromAll($sc['convenience_id'])) {
                array_push($this->conveniences[$sc['salon_id']], $convenience);
            }

        }
        return $this->conveniences[$salonId] ?? [];
    }

    /**
     * @param int $salonId
     * @return array
     */
    public function getUsers(int $salonId): array
    {
        if ($this->users) return $this->users[$salonId] ?? [];

        $salonsUsers = (new Query())->from(SalonUser::tableName())
            ->isAccount()
            ->all();

        $users = UserRepository::getInstance()
            ->findAllById(ArrayHelper::getColumn($salonsUsers, 'user_id'), 'id');

        foreach ($salonsUsers as &$su) {
            if (empty($this->users[$su['salon_id']])) $this->users[$su['salon_id']] = [];

            if (!empty($users[$su['user_id']])) {
                array_push($this->users[$su['salon_id']], $users[$su['user_id']]);
            }
        }
        return $this->users[$salonId] ?? [];
    }

    /**
     * @param int $salonId
     * @return mixed|null
     */
    public function getServices(int $salonId)
    {
        if ($this->services) return $this->services[$salonId] ?? [];

        $salonUserServices = (new Query())->from(UserService::tableName())
            ->isAccount()
            ->all();

        $serviceRepository = ServiceRepository::getInstance();

        foreach ($salonUserServices as &$sus) {
            if (empty($this->services[$sus['salon_id']])) $this->services[$sus['salon_id']] = [];

            if ($service = $serviceRepository->findByIdFromAll($sus['service_id'])) {
                array_push($this->services[$sus['salon_id']], $service);
            }
        }
        return $this->services[$salonId] ?? [];
    }
}