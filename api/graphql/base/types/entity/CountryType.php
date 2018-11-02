<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;

/**
 * Class CountryType
 *
 * @package api\graphql\base\types\entity
 */
class CountryType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'name' => $this->typeRegistry->string(),
            'currency_code' => $this->typeRegistry->string(),
            'currency_string_code' => $this->typeRegistry->string(),
            'phone_code' => $this->typeRegistry->string()
        ];
    }
}