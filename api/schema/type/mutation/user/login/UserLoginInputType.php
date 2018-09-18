<?php

namespace api\schema\type\mutation\user\login;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserFormLoginType
 * @package api\schema\type\mutation\user\login
 */
class UserLoginInputType extends InputObjectType
{
    /**
     * UserFormLoginType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'phone' => $typeRegistry->nonNull($typeRegistry->int()),
                    'password' => $typeRegistry->nonNull($typeRegistry->string()),
                ];
            }
        ]);
    }
}