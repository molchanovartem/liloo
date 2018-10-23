<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;

/**
 * Class TariffPriceType
 *
 * @package api\graphql\base\types\entity
 */
class TariffPriceType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'tariff_id' => $this->typeRegistry->id(),
            'price' => $this->typeRegistry->float(),
            'day' => $this->typeRegistry->int(),
        ];
    }
}
