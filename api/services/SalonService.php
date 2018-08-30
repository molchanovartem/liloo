<?php

namespace api\services;

use Yii;
use yii\db\Exception;
use yii\db\Expression;
use common\models\SalonConvenience;
use common\models\SalonSpecialization;
use api\exceptions\ValidationError;
use api\models\Master;
use api\models\SalonMaster;
use api\exceptions\NotFoundEntryError;
use api\exceptions\AttributeValidationError;
use api\models\Salon;
use api\models\SalonService as SalonServiceModel;

/**
 * Class SalonService
 *
 * @package api\services
 */
class SalonService extends \api\services\Service
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';


    /**
     * @param array $data
     * @return Salon
     * @throws AttributeValidationError
     * @throws Exception
     * @throws ValidationError
     */
    public function create(array $data)
    {
        return $this->save(new Salon(), $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Salon
     * @throws AttributeValidationError
     * @throws Exception
     * @throws NotFoundEntryError
     * @throws ValidationError
     */
    public function update(int $id, array $data)
    {
        if (!$model = Salon::find()->oneById($id)) throw new NotFoundEntryError();

        return $this->save($model, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool)Salon::deleteById($id);
    }

    /**
     * @param Salon $model
     * @param $data
     * @return Salon
     * @throws AttributeValidationError
     * @throws Exception
     * @throws ValidationError
     */
    private function save(Salon $model, $data)
    {
        $model->setAttributes($data);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        return $this->wrappedTransaction(function () use ($model, $data) {
            $model->save(false);
            $this->updateSpecializations($model->id, $data['specializations_id'] ?? []);
            $this->updateConveniences($model->id, $data['conveniences_id'] ?? []);

            return $model;
        });
    }

    /**
     * @param int $salonId
     * @param array $specializationsId
     * @param bool $validation
     * @return bool
     * @throws Exception
     * @throws ValidationError
     */
    public function updateSpecializations(int $salonId, array $specializationsId, $validation = true): bool
    {
        if (!$specializationsId) return false;

        $this->checkExistSalon($salonId);

        $batch = [];
        foreach ($specializationsId as $id) {
            $batch[] = [
                'account_id' => Yii::$app->account->getId(),
                'salon_id' => $salonId,
                'specialization_id' => $id
            ];
        }

        return $this->wrappedTransaction(function () use ($salonId, $specializationsId, $batch, $validation) {
            SalonSpecialization::deleteAll(['salon_id' => $salonId, 'account_id' => Yii::$app->account->getId()]);

            return (bool)Yii::$app->db->createCommand()->batchInsert(SalonSpecialization::tableName(), [
                'account_id', 'salon_id', 'specialization_id'
            ], $batch ?? [])->execute();
        });
    }

    /**
     * @param int $salonId
     * @param array $specializationsId
     * @return bool
     * @throws Exception
     * @throws NotFoundEntryError
     */
    public function deleteSpecializations(int $salonId, array $specializationsId = [])
    {
        if (!$specializationsId) {
            $result = SalonSpecialization::deleteAll(['salon_id' => $salonId, 'account_id' => Yii::$app->account->getId()]);
        } else {
            $result = Yii::$app->db->createCommand()->delete(SalonSpecialization::tableName(), new Expression(
                    "FIND_IN_SET(`specialization_id`, :specializationsId) AND `account_id` = :accountId AND `salon_id` = :salonId",
                    [
                        ':specializationsId' => implode(',', $specializationsId),
                        ':accountId' => Yii::$app->account->getId(),
                        ':salonId' => $salonId
                    ])
            )->execute();
        }
        if ($result == 0) throw new NotFoundEntryError();

        return (bool)$result;
    }

    /**
     * @param int $salonId
     * @param array $conveniencesId
     * @return bool
     * @throws Exception
     * @throws ValidationError
     */
    public function updateConveniences(int $salonId, array $conveniencesId)
    {
        if (!$conveniencesId) return false;

        $this->checkExistSalon($salonId);

        $batch = [];
        foreach ($conveniencesId as $id) {
            $batch[] = [
                'account_id' => Yii::$app->account->getId(),
                'salon_id' => $salonId,
                'convenience_id' => $id
            ];
        }

        return $this->wrappedTransaction(function () use ($salonId, $conveniencesId, $batch) {
            SalonConvenience::deleteAll(['salon_id' => $salonId, 'account_id' => Yii::$app->account->getId()]);

            return (bool)Yii::$app->db->createCommand()->batchInsert(SalonConvenience::tableName(), [
                'account_id', 'salon_id', 'convenience_id'
            ], $batch ?? [])->execute();
        });
    }

    /**
     * @param int $salonId
     * @param array $conveniencesId
     * @return bool
     * @throws Exception
     * @throws NotFoundEntryError
     */
    public function deleteConveniences(int $salonId, array $conveniencesId = []): bool
    {
        if (!$conveniencesId) {
            $result = SalonConvenience::deleteAll(['salon_id' => $salonId, 'account_id' => Yii::$app->account->getId()]);
        } else {
            $result = Yii::$app->db->createCommand()->delete(SalonConvenience::tableName(), new Expression(
                    "FIND_IN_SET(`convenience_id`, :conveniencesId) AND `account_id` = :accountId AND `salon_id` = :salonId",
                    [
                        ':conveniencesId' => implode(',', $conveniencesId),
                        ':accountId' => Yii::$app->account->getId(),
                        ':salonId' => $salonId
                    ])
            )->execute();
        }
        if ($result == 0) throw new NotFoundEntryError();

        return (bool)$result;
    }

    /**
     * @param array $attributes
     * @return SalonServiceModel
     * @throws AttributeValidationError
     */
    public function createSalonService(array $attributes)
    {
        return $this->saveSalonService(new SalonServiceModel(), $attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return SalonServiceModel
     * @throws AttributeValidationError
     * @throws NotFoundEntryError
     */
    public function updateSalonService(int $id, array $attributes)
    {
        if (!$model = SalonServiceModel::find()->oneById($id)) throw new NotFoundEntryError();

        return $this->saveSalonService($model, $attributes);
    }

    /**
     * @param SalonServiceModel $model
     * @param array $attributes
     * @return SalonServiceModel
     * @throws AttributeValidationError
     */
    private function saveSalonService(SalonServiceModel $model, array $attributes)
    {
        $model->setAttributes($attributes);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        return $model;
    }

    /**
     * @param array $items
     * @return array|\yii\db\ActiveRecord[]
     * @throws AttributeValidationError
     */
    public function createSalonServices(array $items)
    {
        return $this->saveSalonServices($items, self::SCENARIO_CREATE);
    }

    /**
     * @param array $items
     * @return array|\yii\db\ActiveRecord[]
     * @throws AttributeValidationError
     */
    public function updateSalonServices(array $items)
    {
        return $this->saveSalonServices($items, self::SCENARIO_UPDATE);
    }

    /**
     * @param array $items
     * @param $scenario
     * @return array|\yii\db\ActiveRecord[]
     * @throws AttributeValidationError
     */
    private function saveSalonServices(array $items, $scenario)
    {
        $models = [];
        if ($scenario === self::SCENARIO_CREATE) {
            foreach ($items as $key => $item) {
                $models[$key] = new SalonServiceModel($item);

                if (!$models[$key]->validate()) throw new AttributeValidationError($models[$key]->getErrors());
                $models[$key]->save(false);
            }
        } else {
            $models = SalonServiceModel::find()->allById(array_column($items, 'id'));
            foreach ($items as $key => $item) {
                $models[$item['id']]->setAttributes($item['attributes']);

                if (!$models[$item['id']]->validate()) throw new AttributeValidationError($models[$key]->getErrors());
                $models[$item['id']]->save(false);
            }
        }
        return $models;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteSalonService(int $id): bool
    {
        return (bool) SalonServiceModel::deleteById($id);
    }

    /**
     * @param array $id
     * @return bool
     * @throws Exception
     */
    public function deleteSalonServices(array $id = []): bool
    {
        return (bool)Yii::$app->db->createCommand()->delete(SalonServiceModel::tableName(), new Expression(
            "FIND_IN_SET(`id`, :id) AND `account_id` = :accountId",
            [
                ':id' => implode(',', $id),
                ':accountId' => Yii::$app->account->getId()
            ]))->execute();
    }

    /**
     * @param int $salonId
     * @param int $masterId
     * @return SalonMaster
     * @throws AttributeValidationError
     */
    public function createSalonMaster(int $salonId, int $masterId)
    {
        $model = new SalonMaster([
            'salon_id' => $salonId,
            'master_id' => $masterId
        ]);

        if (!$model->validate()) throw new AttributeValidationError($model->getErrors());

        $model->save(false);
        return $model;
    }

    /**
     * @param int $salonId
     * @param array $mastersId
     * @return bool
     * @throws Exception
     * @throws ValidationError
     * @throws \yii\base\Exception
     */
    public function createSalonMasters(int $salonId, array $mastersId): bool
    {
        return $this->saveSalonMasters($salonId, $mastersId);
    }

    /**
     * @param int $salonId
     * @param array $mastersId
     * @return bool
     * @throws Exception
     */
    public function updateSalonMasters(int $salonId, array $mastersId): bool
    {
        return $this->wrappedTransaction(function () use ($salonId, $mastersId) {
            SalonMaster::deleteAll([
                'account_id' => Yii::$app->account->getId(),
                'salon_id' => $salonId
            ]);
            return $this->saveSalonMasters($salonId, $mastersId);
        });
    }

    /**
     * @param int $salonId
     * @param array $mastersId
     * @return bool
     * @throws Exception
     * @throws ValidationError
     * @throws \yii\base\Exception
     */
    private function saveSalonMasters(int $salonId, array $mastersId)
    {
        $this->checkExistSalon($salonId);

        $masters = Master::find()
            ->select(['id'])
            ->indexBy('id')
            ->allByAccountId();

        $batch = [];
        foreach ($mastersId as $masterId) {
            if (!key_exists($masterId, $masters)) throw new ValidationError('Not found master');

            $batch[] = [
                'account_id' => Yii::$app->account->getId(),
                'salon_id' => $salonId,
                'master_id' => $masterId,
            ];
        }

        if ($batch) {
            Yii::$app->db->createCommand()->batchInsert(SalonMaster::tableName(), [
                'account_id', 'salon_id', 'master_id'
            ], $batch)->execute();
        }
        return (bool)$batch;
    }

    /**
     * @param int $salonId
     * @param int $masterId
     * @return bool
     */
    public function deleteSalonMaster(int $salonId, int $masterId): bool
    {
        return (bool) SalonMaster::deleteOne($salonId, $masterId);
    }

    /**
     * @param int $salonId
     * @param array $mastersId
     * @return bool
     * @throws Exception
     * @throws NotFoundEntryError
     */
    public function deleteMasters(int $salonId, array $mastersId = [])
    {
        $accountId = Yii::$app->account->getId();

        if (!$mastersId) {
            $result = SalonMaster::deleteAll([
                'account_id' => $accountId,
                'salon_id' => $salonId
            ]);
        } else {
            $result = Yii::$app->db->createCommand()->delete(SalonMaster::tableName(), new Expression(
                    "FIND_IN_SET(`master_id`, :mastersId) AND `account_id` = :accountId AND `salon_id` = :salonId",
                    [
                        ':accountId' => $accountId,
                        ':mastersId' => implode(',', $mastersId),
                        ':salonId' => $salonId
                    ])
            )->execute();
        }
        if ($result == 0) throw new NotFoundEntryError();

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
}