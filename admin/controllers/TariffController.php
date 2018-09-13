<?php

namespace admin\controllers;

use admin\services\TariffService;

/**
 * Class TariffController
 * @package admin\controllers
 */
class TariffController extends Controller
{
    /**
     * TariffController constructor.
     * @param string $id
     * @param $module
     * @param TariffService $tariffService
     * @param array $config
     */
    public function __construct(string $id, $module, TariffService $tariffService, array $config = [])
    {
        $this->modelService = $tariffService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->modelService->getDataProvider();
        $data = $this->modelService->getData();

        return $this->render('index', [
            'dataProvider' => $data['provider'],
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionView($id)
    {
        $this->modelService->findTariff($id);
        $this->modelService->findTariffPrice($id);

        $data = $this->modelService->getData();

        return $this->render('view', [
            'model' => $data['tariff'],
            'prices' => $data['price'],
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        return $this->create('create');
    }

    /**
     * @param $tariffId
     * @return string|\yii\web\Response
     */
    public function actionCreatePrice($tariffId)
    {
        $model = $this->modelService->savePrice($tariffId);

        if ($model) {
            return $this->redirect(['view', 'id' => $tariffId]);
        }

        return $this->render('create-price', [
            'model' => $this->modelService->getData()['model'],
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        return $this->create('update', ['id' => $id]);
    }

    /**
     * @param $type
     * @param array $params
     * @return string|\yii\web\Response
     */
    public function create($type, $params = [])
    {
        $result = $this->modelService->save($type, $params);
        $data = $this->modelService->getData();
        return $result ? $this->redirect(['view', 'id' => $data['model']->id]) :
            $this->render($type, [
                'model' => $data['model'],
                'access' => $data['access']
            ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $this->modelService->delete($id);

        return $this->redirect(['index']);
    }

    public function actionCreateTariff()
    {

    }
}
