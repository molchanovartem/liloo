<?php

namespace site\widgets\specialization;

use yii\base\Widget;
use common\models\Service;
use common\models\Specialization as Spec;

/**
 * Class Specialization
 * @package site\widgets\specialization
 */
class Specialization extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $specializations = Spec::find()
            ->alias('spec')
            ->select(['MIN(serv.price) as price', 'spec.name', 'spec.id'])
            ->leftJoin(Service::tableName() . ' serv', 'serv.specialization_id = spec.id')
            ->groupBy('spec.name, spec.id')
            ->asArray()
            ->all();

        return $this->render('index', [
            'specializations' => $specializations,
        ]);
    }
}
