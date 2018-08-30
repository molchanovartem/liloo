<?php

namespace api\modules\v1\services;

use yii\helpers\ArrayHelper;

/**
 * Class ModelService
 * @package api\modules\v1\services
 */
abstract class ModelService
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @var null
     */
    protected $result = null;

    /**
     * @param array $data
     * @return $this
     */
    public function addData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData($key, $default = null)
    {
       return ArrayHelper::getValue($this->data, $key, $default);
    }

    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $data
     */
    public function setResult($data)
    {
        $this->result = $data;
    }

    protected function getAccountId()
    {
        //return Yii::$app->account->getId();
        return 1;
    }
}