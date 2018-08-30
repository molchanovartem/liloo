<?php

namespace api\schema\type\query;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class UserProfileType
 * @package api\schema\query
 */
class UserProfileType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function () {
                return [
                    'id' => Type::int(),
                    'user_id' => Type::int(),
                    'surname' => Type::string(),
                    'name' => Type::string(),
                    'patronymic' => Type::string(),
                    'date_birth' => Type::string(),
                    'avatar' => Type::string(),
                ];
            }
        ];

        parent::__construct($config);
    }
}