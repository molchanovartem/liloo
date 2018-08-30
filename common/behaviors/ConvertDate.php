<?php

namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class ConvertDate
 * @package app\core\behaviors
 */
class ConvertDate extends \yii\base\Behavior
{
    /**
     * @var string|array
     */
    public $attribute;
    /**
     * @var string
     */
    public $format = 'php:Y-m-d';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        if (is_array($this->attribute)) {
            foreach ($this->attribute as $attribute) {
                $this->formatDate($attribute);
            }
        } else {
            $this->formatDate($this->attribute);
        }
    }

    /**
     * @param string $attribute
     */
    protected function formatDate($attribute)
    {
        if ($this->owner->{$attribute} != '') {
            $this->owner->{$attribute} = Yii::$app->formatter->asDate($this->owner->{$attribute}, $this->format);
        }
    }
}