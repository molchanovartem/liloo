<?php

namespace api\graphql\base\types\entity;

use api\graphql\core\EntityType;

/**
 * Class MasterType
 *
 * @package api\graphql\base\types\entity
 */
class MasterType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'user_id' => $this->typeRegistry->id(),
            'surname' => $this->typeRegistry->string(),
            'name' => $this->typeRegistry->string(),
            'patronymic' => $this->typeRegistry->string(),
            'date_birth' => $this->typeRegistry->date()
        ];
    }
}