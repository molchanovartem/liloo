<?php

namespace api\graphql\lk\types\mutation\client;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\ClientService;

/**
 * Class ClientType
 *
 * @package api\graphql\lk\types\mutation\client
 */
class ClientType implements MutationFieldsTypeInterface
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
            'clientCreate' => [
                'type' => $entityType->client(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputType->clientCreate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new ClientService())->create($args['attributes']);
                }
            ],
            'clientUpdate' => [
                'type' => $entityType->client(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputType->clientUpdate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new ClientService())->update($args['id'], $args['attributes']);
                }
            ],
            'clientDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return (new ClientService())->delete($args['id']);
                }
            ],
        ];
    }
}