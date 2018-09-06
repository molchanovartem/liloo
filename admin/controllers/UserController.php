<?php

namespace admin\controllers;

use admin\services\UserService;
use Yii;
use yii\data\ActiveDataProvider;
use admin\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use admin\models\User;
use admin\models\UserInteraction;

/**
 * Class UserController
 * @package app\modules\admin\controllers
 */
class UserController extends \admin\controllers\Controller
{

    public function __construct(string $id, $module, UserService $userService, array $config = [])
    {
        $this->modelService = $userService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'interactions' => UserInteraction::find()->where(['user_id' => $id])->all(),
        ]);
    }


    public function actionCreateInteraction($userId)
    {
        $model = $this->modelService->createInteraction($userId);

        if ($model) {
            return $this->redirect(['view', 'id' => $userId]);
        }

        return $this->render('create-interaction', [
            'model' => $model,
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

    public function create($type, $params = [])
    {
        $result = $type == 'create' ? $this->modelService->create() : $this->modelService->update($params['id']);
        $data = $this->modelService->getData();

        return $result ? $this->redirect(['view', 'id' => $data['model']->id]) :
            $this->render($type, ['model' => $data['model']
            ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->modelService->delete($id);

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return User|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
