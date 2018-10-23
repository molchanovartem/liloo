<?php

namespace api\graphql\lk\types\entity;

use api\graphql\core\TypeRegistry;
use api\graphql\core\QueryTypeInterface;
use common\models\UserProfile;

/**
 * Class UserProfileType
 *
 * @package api\graphql\lk\types\entity
 */
class UserProfileType implements QueryTypeInterface
{
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