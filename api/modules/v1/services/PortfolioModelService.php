<?php

namespace api\modules\v1\services;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\db\Exception;
use yii\db\ActiveRecord;
use api\modules\v1\models\Portfolio;

//use app\core\models\PortfolioImage;

/**
 * Class PortfolioModelService
 * @package app\modules\api\services\v1
 */
class PortfolioModelService extends ModelService
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function index($salonId = null, $serviceId = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Portfolio::find()
                ->filterWhere(['salon_id' => $salonId, 'service_id' => $serviceId])
                ->isAccount()
        ]);

        $this->setResult($dataProvider);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function view(int $id): bool
    {
        $model = Portfolio::find()
            ->where(['id' => $id])
            ->one();

        $this->addData(['model' => $model]);
        $this->setResult($model);

        return (bool) $model;
    }

    /**
     * @return bool
     * @throws Exception
     * @throws NoModelException
     */
    public function create(): bool
    {
        return $this->save(self::SCENARIO_CREATE);
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     * @throws NoModelException
     */
    public function update($id): bool
    {
        return $this->save(self::SCENARIO_UPDATE, ['id' => $id]);
    }

    /**
     * @param integer $id
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete($id)
    {
        $portfolioImages = PortfolioImage::find()
            ->where(['portfolio_id' => $id])
            ->all();

        foreach ($portfolioImages as $portfolioImage) {
            $portfolioImage->delete();
        }
        Portfolio::deleteAll(['id' => $id, 'account_id' => $this->getAccountId()]);
        return true;
    }

    public function setItemsSort()
    {
        $items = $this->getData('post');

        foreach ($items as $id => $sort) {
            if (is_numeric($id) && is_numeric($sort)) {
                Portfolio::updateAll(['sort' => $sort], ['id' => $id]);
            }
        }
        return true;
    }

    /**
     * @param $scenario
     * @param array $conditions
     * @return bool
     * @throws Exception
     * @throws NoModelException
     */
    private function save($scenario, $conditions = []): bool
    {
        $this->form = new PortfolioForm();
        $this->form->load($this->getData('post'));
        $this->form->uploadImages = UploadedFile::getInstances($this->form, 'uploadImages');

        if ($scenario === self::SCENARIO_UPDATE) {
            $this->initPortfolioImages($conditions['id']);
            ActiveRecord::loadMultiple($this->portfolioImages, $this->getData('post'));
        }

        if ($result = $this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($scenario === self::SCENARIO_CREATE) {
                    $model = new Portfolio();
                    $model->setAttributes($this->form->getAttributes());

                    if ($model->save()) {
                        $this->uploadImages($model->id, $model->account_id, $this->form->uploadImages);
                    }
                } else if ($scenario === self::SCENARIO_UPDATE) {
                    $model = Portfolio::find()
                        ->where($conditions)
                        ->one();

                    if (!$model) {
                        throw new NoModelException();
                    }

                    $model->setAttributes($this->form->getAttributes());

                    if ($model->save()) {
                        $this->uploadImages($model->id, $model->account_id, $this->form->uploadImages);
                    }
                    $this->processPortfolioImages();
                }

                $transaction->commit();
            } catch (Exception $exception) {
                $transaction->rollBack();

                throw $exception;
            }
        }

        $this->readModelErrors($this->form);
        $this->readModelErrors($this->portfolioImages, true);
        return $result;
    }

    /**
     * @return bool
     */
    private function validate(): bool
    {
        return ($this->form->validate() && $this->validatePortfolioImages());
    }

    /**
     * @return bool
     */
    private function validatePortfolioImages(): bool
    {
        $result = true;
        foreach ($this->portfolioImages as $portfolioImage) {
            if (!$portfolioImage->validate()) {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * @param int $portfolioId
     * @param int $accountId
     * @param array $images
     */
    private function uploadImages(int $portfolioId, int $accountId, $images = [])
    {
        foreach ($images as $instance) {
            $model = new PortfolioImage([
                'account_id' => $accountId,
                'portfolio_id' => $portfolioId,
                'file' => $instance
            ]);
            $model->save();
        }
    }

    /**
     * @param $portfolioId
     */
    private function initPortfolioImages($portfolioId)
    {
        $this->portfolioImages = PortfolioImage::find()
            ->where(['portfolio_id' => $portfolioId])
            ->isAccount()
            ->indexBy('id')
            ->all();
    }

    private function processPortfolioImages()
    {
        foreach ($this->portfolioImages as $portfolioImage) {
            if ($portfolioImage->isDelete) {
                $portfolioImage->delete();
                continue;
            }
            $portfolioImage->save(false);
        }
    }
}