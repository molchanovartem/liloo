<?php

namespace api\services;

use common\validators\MasterExistValidator;
use common\validators\MasterScheduleExistValidator;
use common\validators\SalonExistValidator;
use DateTime;
use Yii;
use yii\db\Expression;
use api\exceptions\ValidationError;
use api\models\Salon;
use api\models\MasterSchedule;
use api\exceptions\AttributeValidationError;
use api\exceptions\NotFoundEntryError;
use api\models\Master;
use api\models\MasterSpecialization;
use api\models\MasterService as MasterServiceModel;
use yii\helpers\ArrayHelper;

class MasterService extends Service
{
    /**
     * @param array $attributes
     * @return Master
     * @throws AttributeValidationError
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    public function create(array $attributes)
    {
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
        if (!$model = Master::find()->oneById($id)) throw new NotFoundEntryError();

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
            $result = $model->save(false);
            $this->updateSpecializations($model->id, ArrayHelper::getValue($attributes, 'specializations_id', []));

            return $result;
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

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(MasterSpecialization::tableName(), [
                'account_id', 'master_id', 'specialization_id'
            ], $batch)->execute();
        }
        return (bool)$batch;
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
        return $this->saveMasterSchedule(new MasterSchedule(), $attributes, \common\models\MasterSchedule::SCENARIO_DEFAULT);
    }

    /**
     * @param array $items
     * @return bool
     * @throws AttributeValidationError
     * @throws \yii\db\Exception
     */
    public function createMasterSchedules(array $items)
    {
        return $this->saveMasterSchedules($items, \common\models\MasterSchedule::SCENARIO_BATCH);
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
        if (!$model = MasterSchedule::find()->oneById($id)) throw new NotFoundEntryError();

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
        $model->setAttributes($attributes);
        $model->setScenario($modelScenario);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());
        $model->save(false);

        return $model;
    }

    /**
     * @param array $items
     * @param $modelScenario
     * @return bool
     * @throws AttributeValidationError
     * @throws \yii\db\Exception
     */
    private function saveMasterSchedules(array $items, $modelScenario): bool
    {
        $attributes = ['account_id', 'master_id', 'salon_id', 'type', 'start_date', 'end_date'];
        $batch = [];
        $models = [];

        $this->validateSalonServices($items);

        foreach ($items as $key => $item) {
            $item['type'] = MasterSchedule::TYPE_WORKING;
            $models[$key] = new MasterSchedule($item);
            $models[$key]->setScenario($modelScenario);

            if (!$models[$key]->validate()) throw new AttributeValidationError($models[$key]->getErrors());
            $batch[] = $models[$key]->getAttributes($attributes);
        }

        return (bool)Yii::$app->db->createCommand()->batchInsert(MasterSchedule::tableName(), $attributes, $batch)->execute();
    }

    /**
     * @param array $items
     * @throws AttributeValidationError
     */
    private function validateSalonServices(array $items)
    {
        $errors = '';
        if (!(new MasterScheduleExistValidator())->validate($items, $errors)) {
            throw new AttributeValidationError([$errors]);
        }

        if (!(new MasterExistValidator())->validate(ArrayHelper::getColumn($items, 'master_id'), $errors)) {
            throw new AttributeValidationError([$errors]);
        }

        if (!(new SalonExistValidator())->validate(ArrayHelper::getColumn($items, 'salon_id'), $errors)) {
            throw new AttributeValidationError([$errors]);
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteSchedule(int $id): bool
    {
        return (bool)MasterSchedule::deleteOneById($id);
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
        if (!Salon::find()->existsById($salonId)) throw new ValidationError('Not found salon');
    }

    /**
     * @param int $masterId
     * @throws ValidationError
     */
    private function checkExistMaster(int $masterId)
    {
        if (!Master::find()->existsById($masterId)) throw new ValidationError('Not found master');
    }
}