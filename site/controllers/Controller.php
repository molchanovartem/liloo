<?php

namespace site\controllers;

use Yii;
use common\core\service\ModelService;
use common\core\service\ViewService;

/**
 * Class Controller
 * @package site\controllers
 */
abstract class Controller extends \yii\web\Controller
{
    const EVENT_CREATE = 'eventCreate';
    const EVENT_UPDATE = 'eventUpdate';
    const EVENT_DELETE = 'eventDelete';

    /**
     * @var string
     */
    public $layout = '@site/views/layouts/flexible.php';

    /**
     * @var string
     */
    public $mainLayout = '@site/views/layouts/option/common.php';

    /**
     * @var ModelService
     */
    public $modelService;
    /**
     * @var ViewService
     */
    public $viewService;

    public function init()
    {
        if ($this->modelService instanceof ModelService) {
            $this->modelService->data = [
                'get' => Yii::$app->request->getQueryParams(),
                'post' => Yii::$app->request->post(),
            ];
        }
        parent::init();
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $content = $this->renderPartial($view, $params);
        $layoutContent = $this->renderContent($content);

        return parent::renderPartial($this->mainLayout, ['content' => $layoutContent]);
    }

    /**
     * @param $view
     * @param array $params
     * @return array|string
     */
    public function extraRender($view, $params = [])
    {
        if (!Yii::$app->request->isAjax) {
            return $this->render($view, $params);
        }

        return $this->asJson([
            'content' => $this->renderAjax($this->layout, ['content' => $this->renderPartial($view, $params)]),
        ]);
    }
}
