<?php

namespace api\graphql\lk\types\entity;

use GraphQL\Type\Definition\ObjectType;
use api\graphql\TypeRegistry;
use api\graphql\QueryTypeInterface;
use api\models\UserProfile;

/**
 * Class UserProfileType
 *
 * @package api\graphql\lk\types\entity
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
                    'country_id' => $typeRegistry->id(),
                    'city_id' => $typeRegistry->id(),
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'avatar' => $typeRegistry->string(),
                    'description' => $typeRegistry->string(),
                    'address' => $typeRegistry->string(),
                    'phone' => $typeRegistry->string()
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
                    return UserProfile::find()->oneByCurrentUserId();
                }
            ]
        ];
    }


}