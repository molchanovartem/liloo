<?php

namespace common\components\tariffAccess;

/**
 * Interface RuleInterface
 *
 * @package common\components\tariffAccess
 */
interface RuleInterface
{
    /**
     * @return string
     */
    public static function getName(): string;
}