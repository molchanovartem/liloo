<?php

namespace api\graphql\lk\services;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use api\services\Service;
use api\validators\MasterExistValidator;
use api\validators\MasterScheduleValidator;
use api\validators\SalonExistValidator;
use api\graphql\core\errors\ValidationError;
use api\models\lk\Salon;
use api\models\lk\MasterSchedule;
use api\graphql\core\errors\AttributeValidationError;
use api\graphql\core\errors\NotFoundEntryError;
use api\models\lk\Master;
use api\models\lk\MasterSpecialization;
use api\models\lk\MasterService as MasterServiceModel;

/**
 * Class MasterService
 *
 * @package api\graphql\lk\services
 */
class MasterService extends Service
{
    const ACTION_BEFORE_CREATE = 'beforeCreate';
    const ACTION_CREATE = 'create';

    public function init()
    {
        parent::init();

        $this->on(self::ACTION_BEFORE_CREATE, function () {
            //Yii::$app->tariffAccess->master->beforeCreate();
        });
    }

    /**
     * @param array $attributes
     * @return Master
     * @throws AttributeValidationError
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    public function create(array $attributes)
    {
        $this->trigger(self::ACTION_BEFORE_CREATE);

        return $this->save(new Master(), $attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return Master
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    public function update(int $id, array $attributes)
    {
        $model = Master::find()
            ->byCurrentAccountId()
            ->oneById($id);

        if (!$model) throw new NotFoundEntryError();

        return $this->save($model, $attributes);
    }

    /**
     * @param Master $model
     * @param array $attributes
     * @return Master
     * @throws AttributeValidationError
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    private function save(Master $model, array $attributes)
    {
        $model->setAttributes($attributes);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        return $this->wrappedTransaction(function () use ($model, $attributes) {
            $model->save(false);
            $this->updateSpecializations($model->id, ArrayHelper::getValue($attributes, 'specializations_id', []));

            return $model;
        });
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool)Master::deleteById($id);
    }

    /**
     * @param int $masterId
     * @param array $specializationsId
     * @return bool
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    public function createSpecializations(int $masterId, array $specializationsId): bool
    {
        return $this->saveSpecializations($masterId, $specializationsId);
    }

    /**
     * @param int $masterId
     * @param array $specializationsId
     * @return bool
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    public function updateSpecializations(int $masterId, array $specializationsId)
    {
        if (!$specializationsId) return false;

        return $this->wrappedTransaction(function () use ($masterId, $specializationsId) {
            MasterSpecialization::deleteAll([
                'account_id' => Yii::$app->account->getId(),
                'master_id' => $masterId
            ]);
            return $this->saveSpecializations($masterId, $specializationsId);
        });
    }

    /**
     * @param int $masterId
     * @param array $specializationsId
     * @return bool
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    private function saveSpecializations(int $masterId, array $specializationsId)
    {
        if (!$specializationsId) return false;

        $this->checkExistMaster($masterId);

        $batch = [];
        foreach ($specializationsId as $specializationId) {
            $batch[] = [
                'account_id' => Yii::$app->account->getId(),
                'master_id' => $masterId,
                'specialization_id' => $specializationId
            ];
        }

        return (bool)Yii::$app->db->createCommand()->batchInsert(MasterSpecialization::tableName(), [
            'account_id', 'master_id', 'specialization_id'
        ], $batch)->execute();
    }

    /**
     * @param int $masterId
     * @param array $specializationsId
     * @return bool
     * @throws NotFoundEntryError
     * @throws \yii\db\Exception
     */
    public function deleteSpecializations(int $masterId, array $specializationsId = [])
    {
        $accountId = Yii::$app->account->getId();

        if (!$specializationsId) {
            $result = MasterSpecialization::deleteAll(['master_id' => $masterId, 'account_id' => $accountId]);
        } else {
            $result = Yii::$app->db->createCommand()->delete(MasterSpecialization::tableName(), new Expression(
                    "FIND_IN_SET(`specialization_id`, :specializationsId) AND `master_id` = :masterId AND `account_id` = :accountId",
                    [
                        ':accountId' => $accountId,
                        ':specializationsId' => implode(',', $specializationsId),
                        ':masterId' => $masterId
                    ])
            )->execute();
        }
        if ($result == 0) throw new NotFoundEntryError();

        return (bool)$result;
    }

    /**
     * @param array $attributes
     * @return MasterSchedule
     * @throws AttributeValidationError
     */
    public function createMasterSchedule(array $attributes)
    {
        return $this->saveMasterSchedule(new MasterSchedule(), $attributes, MasterSchedule::SCENARIO_DEFAULT);
    }

    /**
     * @param array $items
     * @return null
     * @throws \yii\db\Exception
     */
    public function createMasterSchedules(array $items)
    {
        return $this->wrappedTransaction(function () use ($items) {
            $errors = '';
            if (!(new MasterExistValidator())->validate(ArrayHelper::getColumn($items, 'master_id'), $errors)) {
                throw new AttributeValidationError([$errors]);
            }

            if (!(new SalonExistValidator())->validate(ArrayHelper::getColumn($items, 'salon_id'), $errors)) {
                throw new AttributeValidationError([$errors]);
            }

            // Удаляем записи если даты для сохранения совподают по дням
            if ($repeatMasterSchedulesDate = (new MasterScheduleValidator())->getBadDate($items)) {
                $this->deleteMasterSchedules(array_keys($repeatMasterSchedulesDate));
            }

            $attributes = ['account_id', 'master_id', 'salon_id', 'type', 'start_date', 'end_date'];
            $batch = [];
            $models = [];
            foreach ($items as $key => $item) {
                $item['type'] = MasterSchedule::TYPE_WORKING;
                $models[$key] = new MasterSchedule($item);
                $models[$key]->setScenario(MasterSchedule::SCENARIO_BATCH);

                if (!$models[$key]->validate()) throw new AttributeValidationError($models[$key]->getErrors());
                $batch[] = $models[$key]->getAttributes($attributes);
            }

            return (bool)Yii::$app->db->createCommand()->batchInsert(MasterSchedule::tableName(), $attributes, $batch)->execute();
        });
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return MasterSchedule
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function updateMasterSchedule(int $id, array $attributes)
    {
        $model = MasterSchedule::find()
            ->byCurrentAccountId()
            ->oneById($id);

        if (!$model) throw new NotFoundEntryError();

        return $this->saveMasterSchedule($model, $attributes, \common\models\MasterSchedule::SCENARIO_DEFAULT);
    }

    /**
     * @param MasterSchedule $model
     * @param array $attributes
     * @param $modelScenario
     * @return MasterSchedule
     * @throws AttributeValidationError
     */
    private function saveMasterSchedule(MasterSchedule $model, array $attributes, $modelScenario)
    {
        $model->setScenario($modelScenario);
        $model->setAttributes($attributes);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());
        $model->save(false);

        return $model;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteMasterSchedule(int $id): bool
    {
        return (bool)MasterSchedule::deleteById($id);
    }

    /**
     * @param array $id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function deleteMasterSchedules(array $id): bool
    {
        /*
         * @todo
         *  Проверить id на injectSQL
         */
        return (bool)Yii::$app->db->createCommand()->delete(MasterSchedule::tableName(), new Expression(
                "FIND_IN_SET(`id`, :id) AND `account_id` = :accountId",
                [
                    ':accountId' => Yii::$app->account->getId(),
                    ':id' => implode(',', $id),
                ])
        )->execute();
    }


    /**
     * @param int $masterId
     * @param int $salonId
     * @param array $servicesId
     * @return bool
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    public function createServices(int $masterId, int $salonId, array $servicesId): bool
    {
        return $this->saveServices($masterId, $salonId, $servicesId);
    }

    /**
     * @param int $masterId
     * @param int $salonId
     * @param array $servicesId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function updateServices(int $masterId, int $salonId, array $servicesId): bool
    {
        return $this->wrappedTransaction(function () use ($masterId, $salonId, $servicesId) {
            MasterServiceModel::deleteAll([
                'account_id' => Yii::$app->account->getId(),
                'master_id' => $masterId,
                'salon_id' => $salonId
            ]);

            return $this->saveServices($masterId, $salonId, $servicesId);
        });
    }

    /**
     * @param int $masterId
     * @param int $salonId
     * @param array $servicesId
     * @return bool
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    private function saveServices(int $masterId, int $salonId, array $servicesId)
    {
        if (!$servicesId) return false;

        $this->checkExistMaster($masterId);
        $this->checkExistSalon($salonId);

        $batch = [];
        foreach ($servicesId as $serviceId) {
            $batch[] = [
                'account_id' => Yii::$app->account->getId(),
                'master_id' => $masterId,
                'service_id' => $serviceId,
                'salon_id' => $salonId
            ];
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(MasterServiceModel::tableName(), [
                'account_id', 'master_id', 'service_id', 'salon_id'
            ], $batch)->execute();
        }
        return (bool)$batch;
    }

    /**
     * @param int $masterId
     * @param int $salonId
     * @param array $servicesId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function deleteServices(int $masterId, int $salonId, array $servicesId = []): bool
    {
        $accountId = Yii::$app->account->getId();

        if (!$servicesId) {
            $result = MasterServiceModel::deleteAll([
                'account_id' => $accountId,
                'master_id' => $masterId,
                'salon_id' => $salonId
            ]);
        } else {
            $result = Yii::$app->db->createCommand()->delete(MasterServiceModel::tableName(), new Expression(
                    "FIND_IN_SET(`service_id`, :servicesId) AND `master_id` = :masterId AND `account_id` = :accountId AND `salon_id` = :salonId",
                    [
                        ':accountId' => $accountId,
                        ':servicesId' => implode(',', $servicesId),
                        ':masterId' => $masterId,
                        ':salonId' => $salonId
                    ])
            )->execute();
        }
        return (bool)$result;
    }

    /**
     * @param int $salonId
     * @throws ValidationError
     */
    private function checkExistSalon(int $salonId)
    {
        $model = Salon::find()
            ->byCurrentAccountId()
            ->existsById($salonId);

        if (!$model) throw new ValidationError('Not found salon');
    }

    /**
     * @param int $masterId
     * @throws ValidationError
     */
    private function checkExistMaster(int $masterId)
    {
        $model = Master::find()
            ->byCurrentAccountId()
            ->existsById($masterId);

        if (!$model) throw new ValidationError('Not found master');
    }
}