<?php

namespace site\services;

use common\core\service\ModelService;
use common\models\Service;
use common\models\Specialization;

/**
 * Class SiteService
 * @package site\services
 */
class SiteService extends ModelService
{
    private $servicesMinPrice;

    public function index()
    {
        $specializations = Specialization::find()->all();

        $this->setData(['specializations' => $specializations]);
    }

    /**
     * @param $specializationId
     * @return mixed|null
     */
    public function getServiceMinPrice($specializationId)
    {
        if (!$this->servicesMinPrice) {
            $this->servicesMinPrice = Service::find()
                ->select([new \yii\db\Expression('MIN(`price`) as `price`'), 'specialization_id'])
                ->groupBy('specialization_id')
                ->indexBy('specialization_id')
                ->all();
        }

        return $this->servicesMinPrice[$specializationId]['price'] ?? null;
    }
}
