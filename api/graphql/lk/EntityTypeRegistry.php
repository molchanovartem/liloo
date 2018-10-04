<?php

namespace api\graphql\lk;

use api\graphql\lk\types\entity\AccountType;
use api\graphql\lk\types\entity\AppointmentType;
use api\graphql\lk\types\entity\UserType;

/**
 * Class EntityTypeRegistry
 *
 * @package api\schema\registry
 */
class EntityTypeRegistry extends \api\graphql\base\EntityTypeRegistry
{
    public function account()
    {
        return $this->typeRegistry->get(AccountType::class);
    }

    public function user()
    {
        return $this->typeRegistry->get(UserType::class);
    }

    public function appointment()
    {
        return $this->typeRegistry->get(AppointmentType::class);
    }
}