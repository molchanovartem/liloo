<?php

namespace api\schema\type\mutation\service;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\ServiceService;

/**
 * Class ServiceType
 *
 * @package api\schema\type\mutation\service
 */
class ServiceType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $inputRegistry = $typeRegistry->getMutationInputRegistry();
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