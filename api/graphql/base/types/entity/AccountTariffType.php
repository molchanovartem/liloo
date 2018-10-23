<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;
use common\models\AccountTariff;
use common\models\Tariff;

/**
 * Class AccountTariffType
 *
 * @package api\graphql\base\types\entity
 */
class AccountTariffType extends EntityType
{
   public function fields(): array
   {
       return [
           'id' => $this->typeRegistry->id(),
           'tariff_id' => $this->typeRegistry->id(),
           'price_id' => $this->typeRegistry->id(),
           'start_date' => $this->typeRegistry->string(),
           'end_date' => $this->typeRegistry->string(),
           'tariff' => [
               'type' => $this->entityRegistry->tariff(),
               /*
                * @todo buffer
                */
               'resolve' => function (AccountTariff $accountTariff, $args, $context, $info) {
                   return Tariff::find()->oneById($accountTariff->tariff_id);
               }
           ],
       ];
   }
}