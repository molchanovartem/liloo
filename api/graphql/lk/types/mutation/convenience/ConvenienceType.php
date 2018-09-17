<?php

namespace api\graphql\lk\types\mutation\convenience;

use api\services\ConvenienceService;
use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;

/**
 * Class ConvenienceType
 *
 * @package api\graphql\lk\types\mutation\convenience
 */
class ConvenienceType implements MutationFieldsTypeInterface
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
            'convenienceCreate' => [
                'type' => $entityType->convenience(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputType->convenienceCreate()),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new ConvenienceService())->create($args['attributes']);
                }
            ],
            'convenienceUpdate' => [
                'type' => $entityType->convenience(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputType->convenienceUpdate()),
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new ConvenienceService())->update($args['id'], $args['attributes']);
                }
            ],
            'convenienceDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return (new ConvenienceService())->delete($args['id']);
                }
            ],
        ];
    }
}