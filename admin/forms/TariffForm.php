<?php

namespace admin\forms;

use yii\base\Model;
use common\components\tariffAccess\rules\MasterRule;
use common\models\Tariff;

/**
 * Class TariffForm
 * @package admin\forms
 */
class TariffForm extends Model
{
    private $access;

    public $name;
    public $description;
    public $type;
    public $status;
    public $quantity;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'type', 'status'], 'required'],
            [['type', 'status', 'quantity'], 'integer'],
            [['name', 'description', 'access'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return Tariff::getAttributeLabels();
    }

    /**
     * @param $data
     */
    public function setAccess($data)
    {
        if (is_array($data)) {
            $this->access = $data;
        } else {
            $this->access = explode('/', $data);
        }
    }

    /**
     * @return string
     */
    public function getAccess()
    {
        return implode('/', $this->access ?? []);
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return Tariff::getTypeList();
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        return Tariff::getStatusList();
    }
}