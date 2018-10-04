<?php

namespace api\graphql\base\types\entity;

use api\graphql\EntityType;

/**
 * Class AccountType
 *
 * @package api\graphql\base\types\entity
 */
class AccountType extends EntityType
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'balance' => $this->typeRegistry->decimal(),
        ];
    }
}