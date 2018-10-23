<?php

namespace api\graphql\lk\types\mutation\service;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\ServiceService;

/**
 * Class ServiceType
 *
 * @package api\graphql\lk\types\mutation\service
 */
class ServiceType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $inputRegistry = $typeRegistry->getMutationRegistry();
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'serviceCreate' => [
                'type' => $entityRegistry->service(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->serviceCreate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new ServiceService())->create($args['attributes']);
                }
            ],
            'serviceUpdate' => [
                'type' => $entityRegistry->service(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputRegistry->serviceUpdate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new ServiceService())->update($args['id'], $args['attributes']);
                }
            ],
            'serviceDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => ['id' => $typeRegistry->nonNull($typeRegistry->id())],
                'resolve' => function ($root, $args) {
                    return (new ServiceService())->delete($args['id']);
                }
            ],
        ];
    }

}