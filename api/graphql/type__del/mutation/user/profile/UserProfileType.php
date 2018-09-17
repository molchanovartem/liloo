<?php

namespace api\schema\type\mutation\user\profile;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\UserService;

/**
 * Class UserProfile
 *
 * @package api\schema\type\mutation\user\profile
 */
class UserProfileType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $inputType = $typeRegistry->getMutationInputRegistry();
        $entityType = $typeRegistry->getEntityRegistry();

       return [
           'userProfileUpdate' => [
               'type' => $entityType->userProfile(),
               'args' => [
                   'attributes' => $typeRegistry->nonNull($inputType->userProfileUpdate())
               ],
               'resolve' => function ($root, $args, $context, $info) {
                   return (new UserService())->updateProfile($args['attributes']);
               }
           ],
       ];
    }

}