<?php

namespace app\modules\api\services\v1;

use Yii;
use app\core\models\CommonService;
use app\modules\api\forms\v1\CommonServiceForm;

/**
 * Class CommonServiceModelsService
 * @package app\modules\api\services\v1
 */
class CommonServiceModelsService extends ModelService
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function getItem($arguments = [])
    {
        $query = CommonService::find()
            ->where(['id' => $arguments['id']]);

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }

        $this->setData([
            'item' => $query->one()
        ]);
    }

    public function getItems($arguments = [])
    {
        $query = CommonService::find();

        if ($this->isDataTypeArray()) {
            $query->asArray();
        }

        $this->setData([
            'items' => $query->all()
        ]);
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function create(): bool
    {
        return $this->save(self::SCENARIO_CREATE);
    }

    public function update($id): bool
    {
        return $this->save(self::SCENARIO_UPDATE, ['id' => $id]);
    }

    /**
     * @param $scenario
     * @param array $conditions
     * @return bool
     * @throws \yii\db\Exception
     */
    private function save($scenario, $conditions = [])
    {
        $form = new CommonServiceForm();
        $form->load($this->getData('post'));

        if ($result = $form->validate()) {
            if ($scenario == self::SCENARIO_CREATE) {
                Yii::$app->db->createCommand()->insert(CommonService::tableName(), $form->getAttributes())
                    ->execute();
            } else if ($scenario == self::SCENARIO_UPDATE) {
                Yii::$app->db->createCommand()->update(CommonService::tableName(), $form->getAttributes(), $conditions)
                    ->execute();
            }
        }
        $this->readModelErrors($form);
        return $result;
    }
}