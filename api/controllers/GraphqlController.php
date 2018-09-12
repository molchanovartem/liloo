<?php

namespace api\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\helpers\Json;
use yii\filters\Cors;
use api\schema\GraphQL;
use HttpInvalidParamException;

/**
 * Class GraphqlController
 *
 * @package api\controllers
 */
class GraphqlController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge_recursive(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
                /*
                'cors' => [
                    'Origin' => [
                        'http://lilu',
                        'http://localhost:8080'
                    ]
                ]
                */
            ],
            'bearerAuth' => [
                'class' => HttpBearerAuth::class,
            ],
        ]);
    }


    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['POST', 'OPTIONS'],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [];
    }

    /**
     * @return array
     */
    public function actionIndex()
    {
        $query = \Yii::$app->request->get('query', \Yii::$app->request->post('query'));
        $variables = \Yii::$app->request->get('variables', \Yii::$app->request->post('variables'));
        $operation = \Yii::$app->request->get('operation', \Yii::$app->request->post('operation', null));

        if (empty($query)) {
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variables = isset($input['variables']) ? $input['variables'] : [];
            $operation = isset($input['operation']) ? $input['operation'] : null;
        }

        if (!empty($variables) && !is_array($variables)) {
            try {
                $variables = Json::decode($variables);
            } catch (HttpInvalidParamException $e) {
                $variables = null;
            }
        }

        $graphQl = new GraphQL($query, $variables, $operation);

        $result = $graphQl->getResult();
        $result['data']['profiling'] = [
            'db' => \Yii::$app->getlog()->getLogger()->getDbProfiling(),
            'profiling' => \Yii::$app->getlog()->getLogger()->getProfiling()
        ];

        return $result;
    }
}