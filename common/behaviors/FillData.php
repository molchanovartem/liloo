<?php

namespace app\core\behaviors;


use yii\base\Model;

class FillData extends \yii\base\Behavior
{
	public $attribute;
	public $setAttribute;

	public $filling;

	public function events()
	{
		return [
			Model::EVENT_BEFORE_VALIDATE => 'getData',
		];
	}

	public function getData($event)
	{
		if ($this->owner->{$this->setAttribute} === '') {
			$this->owner->{$this->setAttribute} = $this->owner->{$this->attribute};
		}
	}
}