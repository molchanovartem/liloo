<?php

namespace site\widgets\complaint;

use yii\base\Widget;

/**
 * Class Complaint
 * @package site\widgets\complaint
 */
class Complaint extends Widget
{
    public $recallId;
    public $complaint;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('index', [
            'recallId' => $this->recallId,
            'model' => $this->complaint,
            'complaintList' => $this->complaint->getComplaints(),
        ]);
    }
}
