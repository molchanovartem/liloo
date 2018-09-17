<?php

namespace api\graphql\lk\types\mutation\user\profile;

use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;
use api\services\UserService;

/**
 * Class UserProfileType
 *
 * @package api\graphql\lk\types\mutation\user\profile
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