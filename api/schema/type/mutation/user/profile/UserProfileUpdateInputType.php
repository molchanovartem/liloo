<?php

namespace api\schema\type\mutation\user\profile;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UserProfileUpdateInputType
 *
 * @package api\schema\type\mutation\user\profile
 */
class UserProfileUpdateInputType extends InputObjectType
{
    /**
     * UserProfileUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'description' => $typeRegistry->string()
                ];
            }
        ]);
    }
}