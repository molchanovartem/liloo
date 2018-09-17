<?php

namespace api\graphql\lk\types\mutation\user\service;

use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;

/**
 * Class UserServiceType
 *
 * @package api\graphql\lk\types\mutation\user\service
 */
class UserServiceType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        return [
            'userServicesCreate' => [
                'args' => [
                    'user_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ]
            ],
            'userServicesUpdate' => [
                'args' => [
                    'user_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ]
            ],
            'userServiceDelete' => [

            ],
            'userServiceCreate' => [
                'args' => [
                    'user_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ]
            ],
        ];
    }

}