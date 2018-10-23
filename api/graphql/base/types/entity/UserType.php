<?php

namespace api\graphql\base\types\entity;

use common\models\User;
use api\graphql\core\EntityType;

/**
 * Class UserType
 *
 * @package api\graphql\base\types\entity
 */
class UserType extends EntityType
{
    public function fields(): array
    {
        return [
            'id' => $this->typeRegistry->id(),
            'account_id' => $this->typeRegistry->id(),
            'type' => $this->typeRegistry->int(),
            'login' => $this->typeRegistry->string(),
            'profile' => [
                'type' => $this->entityRegistry->userProfile(),
                'description' => 'Профиль',
                'resolve' => function (User $user, $args, $context, $info) {
                    return $user->profile;
                }
            ],
            'specializations' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->specialization()),
                'description' => 'Коллекция специализаций',
                'resolve' => function (User $user, $args) {
                    return $user->specializations;
                }
            ],
            'conveniences' => [
                'type' => $this->typeRegistry->listOff($this->entityRegistry->convenience()),
                'description' => 'Коллекция удобств',
                'resolve' => function (User $user, $args) {
                    return $user->conveniences;
                }
            ],
        ];
    }
}