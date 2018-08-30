<?php

namespace common\behaviors;

use yii\db\ActiveRecord;
use yii\base\Model;

/**
 * Class UserId
 *
 * @package common\behaviors
 */
class UserId extends \yii\base\Behavior
{	
	public $attribute = 'user_id';
	
	public function events()
	{
		return [
			ActiveRecord::EVENT_BEFORE_INSERT => 'recordUserId',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'recordUserId',
            Model::EVENT_BEFORE_VALIDATE => 'recordUserId',
		];
	}

	public function recordUserId()
	{
	    if ($this->owner->{$this->attribute} == '') {
            $this->owner->{$this->attribute} = 52;
            //$this->owner->{$this->attribute} = Yii::$app->user->getId();
        }
	}
}
