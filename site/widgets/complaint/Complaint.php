<?php

namespace site\widgets\complaint;

use site\forms\ComplaintForm;
use yii\base\Widget;

/**
 * Class Complaint
 * @package site\widgets\complaint
 */
class Complaint extends Widget
{
    public $recallId;

    const COMPLAINT_TYPE_LIE = 'Ложь';
    const COMPLAINT_TYPE_DIRT = 'Оскорбление';

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('index', [
            'recallId' => $this->recallId,
            'model' => new ComplaintForm(),
        ]);
    }
}
