<?php

namespace common\components\tariffAccess;

use api\graphql\core\errors\NotTariffAccess;

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

    /**
     * @param array $accessList
     * @throws NotTariffAccess
     */
    protected function checkAccess(array $accessList)
    {
        $success = true;
        $existAccess = false;
        foreach ($this->tariffAccess->getTariffs() as $tariff) {
            foreach ($accessList as $name => $access) {
                if ($success === false) break;

                if (in_array($name, $tariff['access'])) {
                    $existAccess = true;

                    $success = is_callable($access) ? $access() : $access;
                }
            }
        }
        if (!$existAccess || !$success) throw new NotTariffAccess();
    }
}