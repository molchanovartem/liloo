<?php

namespace api\modules\v1\actions;

use api\modules\v1\services\ModelService;

/**
 * Class Action
 * @package api\modules\v1\actions
 */
abstract class Action extends \yii\base\Action
{
    /**
     * @var  ModelService
     */
    public $modelService;
}