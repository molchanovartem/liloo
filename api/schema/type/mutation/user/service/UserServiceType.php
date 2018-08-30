<?php

namespace api\schema\type\mutation\user\service;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;

/**
 * Class UserServiceType
 *
 * @package api\schema\type\mutation\user\service
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