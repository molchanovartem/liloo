<?php

namespace admin\core\service;


use yii\base\Component;

/**
 * Class Service
 * @package app\core\service
 */
abstract class Service extends Component implements ModelServiceInterface
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData($key = null, $value = null)
    {
        if (isset($value)) {
            if (isset($this->data[$key][$value])) {
                if ($this->data[$key][$value] === '') {
                    return null;
                }
                return $this->data[$key][$value];
            } else {
                return null;
            }
        }

        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } elseIf (isset($key)) {
            return null;
        }

        return $this->data;
    }

    /**
     * @param $name
     * @param null $data
     * @return bool
     */
    public function hasData($name, $data = null)
    {
        if (!key_exists($name, $this->data)) {
            return false;
        } elseif (($data !== null) && (!key_exists($data, $this->data[$name]))) {
            return false;
        }

        return true;
    }
}