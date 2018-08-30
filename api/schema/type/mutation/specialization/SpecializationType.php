<?php

namespace api\schema\type\mutation\specialization;

use api\schema\type\MutationFieldsTypeInterface;
use api\schema\registry\TypeRegistry;
use api\services\SpecializationService;

/**
 * Class SpecializationType
 *
 * @package api\schema\type\mutation\specialization
 */
class SpecializationType implements MutationFieldsTypeInterface
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
            'specializationCreate' => [
                'type' => $entityType->specialization(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputType->specializationCreate()),
                ],
                'resolve' => function ($root, $args) {
                    return (new SpecializationService())->create($args['attributes']);
                }
            ],
            'specializationUpdate' => [
                'type' => $entityType->specialization(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputType->specializationUpdate()),
                ],
                'resolve' => function ($root, $args) {
                    return (new SpecializationService())->update($args['id'], $args['attributes']);
                }
            ],
            'specializationDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                ],
                'resolve' => function ($root, $args) {
                    return (new SpecializationService())->delete($args['id']);
                }
            ]
        ];
    }

}