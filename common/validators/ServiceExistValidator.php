<?php

namespace common\validators;

use common\models\Service;

/**
 * Class ServiceExistValidator
 *
 * @package common\validators
 */
class ServiceExistValidator extends \yii\validators\ExistValidator
{
    public function init()
    {
        parent::init();

        $this->targetClass = Service::class;
        $this->targetAttribute = 'id';
        $this->filter = function ($query) {
            return $query->byAccountId();
        };
    }
}