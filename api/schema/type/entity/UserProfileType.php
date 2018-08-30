<?php

namespace api\schema\type\entity;

use api\models\UserProfile;
use api\schema\registry\TypeRegistry;
use api\schema\type\QueryTypeInterface;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class UserProfileType
 *
 * @package api\schema\type\entity
 */
class UserProfileType extends ObjectType implements QueryTypeInterface
{
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'user_id' => $typeRegistry->id(),
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'avatar' => $typeRegistry->string(),
                    'description' => $typeRegistry->string()
                ];
            }
        ]);
    }

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'userProfile' => [
                'type' => $entityRegistry->userProfile(),
                 'resolve' => function ($root, $args) {
                    return UserProfile::find()->oneByUserIdCurrentUser();
                }
            ]
        ];
    }


}