<?php

namespace common\components\tariffAccess\rules;

use common\components\tariffAccess\Rule;

/**
 * Class MasterRule
 *
 * @package common\components\tariffAccess\rules
 */
class MasterRule extends Rule
{
    const RULE_MASTER_CREATE = 'm1';

    /**
     * @return string
     */
    public static function getName(): string
    {
       return 'master';
    }

    public function beforeCreate()
    {
        $this->checkAccess([
            self::RULE_MASTER_CREATE => true,
            self::RULE_MASTER_CREATE => function () {
                return true;
            }
        ]);
    }

    public function view()
    {
        $this->checkAccess([
            self::RULE_MASTER_CREATE => true
        ]);
    }
}