<?php

namespace api\controllers;

use yii\rest\Controller;
use yii\helpers\Json;
use yii\filters\Cors;
use api\graphql\TypeRegistry;
use api\graphql\GraphQL;

/**
 * Class GraphqlController
 *
 * @package api\controllers
 */
abstract class GraphqlController extends Controller
{
    /**
     * @var TypeRegistry;
     */
    protected $typeRegistry;

    /**
     * @throws \Exception
     */
    public function init()
    {
        if (!$this->typeRegistry instanceof TypeRegistry) throw new \Exception('No instance typeRegistry');

        parent::init();
    }
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
            } catch (\HttpInvalidParamException $e) {
                $variables = null;
            }
        }
        $graphQl = new GraphQL($query, $variables, $operation, $this->typeRegistry);

        $result = $graphQl->getResult();
        $result['data']['profiling'] = [
            'db' => \Yii::$app->getlog()->getLogger()->getDbProfiling(),
            'profiling' => \Yii::$app->getlog()->getLogger()->getProfiling()
        ];

        return $result;
    }
}
