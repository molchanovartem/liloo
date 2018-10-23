<?php

namespace api\graphql\lk\types\mutation\salon;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\SalonService;

/**
 * Class SalonType
 *
 * @package api\graphql\lk\types\mutation\salon
 */
class SalonType implements MutationFieldsTypeInterface
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