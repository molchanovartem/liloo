<?php

namespace api\schema\type\mutation\recall;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\RecallService;

/**
 * Class RecallType
 * @package api\schema\type\mutation\recall
 */
class RecallType implements MutationFieldsTypeInterface
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
                    'attributes' => $typeRegistry->nonNull($inputRegistry->recallCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new RecallService())->create($args['attributes']);
                }
            ],
            'recallDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return (new RecallService())->delete($args['id']);
                }
            ]
        ];
    }
}