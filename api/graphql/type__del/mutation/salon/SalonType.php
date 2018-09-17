<?php

namespace api\schema\type\mutation\salon;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\SalonService;

/**
 * Class SalonType
 *
 * @package api\schema\type\mutation\salon
 */
class SalonType implements MutationFieldsTypeInterface
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
            'salonCreate' => [
                'type' => $entityRegistry->salon(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->salonCreate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new SalonService())->create($args['attributes']);
                }
            ],
            'salonUpdate' => [
                'type' => $entityRegistry->salon(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputRegistry->salonUpdate())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new SalonService())->update($args['id'], $args['attributes']);
                }
            ],
            'salonDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new SalonService())->delete($args['id']);
                }
            ],
        ];
    }
}