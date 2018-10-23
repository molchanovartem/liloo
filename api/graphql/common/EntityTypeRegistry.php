<?php

namespace api\graphql\common;

use api\graphql\common\types\entity\UserType;

/**
 * Class EntityTypeRegistry
 *
 * @package api\graphql\common
 */
class EntityTypeRegistry extends \api\graphql\base\EntityTypeRegistry
{
    public function user()
    {
        return $this->typeRegistry->get(UserType::class);
    }
}