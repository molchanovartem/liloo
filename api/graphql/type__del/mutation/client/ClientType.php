<?php

namespace api\schema\type\mutation\client;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\ClientService;

/**
 * Class ClientType
 *
 * @package api\schema\type\mutation\client
 */
class ClientType implements MutationFieldsTypeInterface
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