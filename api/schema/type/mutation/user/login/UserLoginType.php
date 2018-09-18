<?php

namespace api\schema\type\mutation\user\login;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\UserService;

/**
 * Class UserLoginType
 * @package api\schema\type\mutation\user\login
 */
class UserLoginType implements MutationFieldsTypeInterface
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
            'recallCreate' => [
                'type' => $entityRegistry->recall(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->userLogin())
                ],
                'resolve' => function ($root, $args) {
                    return (new UserService())->login($args['attributes']);
                }
            ],
        ];
    }
}