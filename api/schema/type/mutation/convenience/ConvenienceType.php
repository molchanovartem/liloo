<?php

namespace api\schema\type\mutation\convenience;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\ConvenienceService;

/**
 * Class ConvenienceType
 *
 * @package api\schema\type\mutation\convenience
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