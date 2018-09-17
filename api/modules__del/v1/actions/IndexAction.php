<?php

namespace api\modules\v1\actions;

/**
 * Class IndexAction
 * @package api\modules\v1\actions
 */
class IndexAction extends Action
{
    public function run()
    {
        $this->modelService->index();

        return $this->modelService->getResult();
    }
}