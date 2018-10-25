<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Model;

/**
 * Class AccountBehavior
 *
 * @package common\behaviors
 */
class AccountBehavior extends Behavior
{
    public $attribute = 'account_id';

    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'beforeValidate'
        ];
    }

    public function beforeValidate($event)
    {
        $this->owner->{$this->attribute} = Yii::$app->account->getId();
    }
}