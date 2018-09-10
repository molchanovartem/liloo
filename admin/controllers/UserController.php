<?php

namespace admin\controllers;

use admin\services\UserService;

/**
 * Class UserController
 * @package admin\controllers
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param string $id
     * @param $module
     * @param UserService $userService
     * @param array $config
     */
    public function __construct(string $id, $module, UserService $userService, array $config = [])
    {
        $this->modelService = $userService;

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
        $this->modelService->findUser($id);
        $this->modelService->findUserInteraction($id);
        $data = $this->modelService->getData();

        return $this->render('view', [
            'model' => $data['user'],
            'interactions' => $data['interactions'],
        ]);
    }

    /**
     * @param $userId
     * @return string|\yii\web\Response
     */
    public function actionCreateInteraction($userId)
    {
        $model = $this->modelService->saveInteraction($userId);

        if ($model) {
            return $this->redirect(['view', 'id' => $userId]);
        }

        return $this->render('create-interaction', [
            'model' => $this->modelService->getData()['model'],
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
            $this->render($type, ['model' => $data['model']
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
}
