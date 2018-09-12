<?php

namespace common\components\tariffAccess;

use GraphQL\Error\Error;

/**
 * Class Rule
 *
 * @package common\components\tariffAccess
 */
abstract class Rule implements RuleInterface
{
    /**
     * @var TariffAccess
     */
    protected $tariffAccess;

    /**
     * Rule constructor.
     *
     * @param TariffAccess $tariffAccess
     */
    public function __construct(TariffAccess $tariffAccess)
    {
        $this->tariffAccess = $tariffAccess;
    }

    protected function checkAccess(array $accessList)
    {
        throw new Error('error tariff access');
    }
}