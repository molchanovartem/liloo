<?php

namespace api\graphql\lk\types\mutation\user\profile;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\UserService;
use yii\web\UploadedFile;

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
        $inputType = $typeRegistry->getMutationRegistry();
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

           // Доделать
           'userAvatarUpload' => [
               'type' => $typeRegistry->string(),
               'args' => [
                   'userId' => $typeRegistry->nonNull($typeRegistry->id()),
                   'attribute' => $typeRegistry->string()
               ],
               'resolve' => function ($root, $args) {
                   return UploadedFile::getInstanceByName($args['attribute'])->getBaseName();
               }
           ]
       ];
    }

}