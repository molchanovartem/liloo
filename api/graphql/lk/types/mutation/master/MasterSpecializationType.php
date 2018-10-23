<?php

namespace api\graphql\lk\types\mutation\master;

use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\core\TypeRegistry;
use api\graphql\lk\services\MasterService;

/**
 * Class MasterSpecializationType
 *
 * @package api\graphql\lk\types\mutation\master
 */
class MasterSpecializationType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        return [
            'masterSpecializationsCreate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'specializations_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->createSpecializations($args['master_id'], $args['specializations_id']);
                }
            ],
            'masterSpecializationsUpdate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'specializations_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new MasterService())->updateSpecializations($args['master_id'], $args['specializations_id']);
                }
            ],
            'masterSpecializationsDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'specializations_id' => [
                        'type' => $typeRegistry->listOff($typeRegistry->id()),
                        'defaultValue' => []
                    ]
                ],
                'resolve' => function ($root, $args, $context, $info) {
                    return (new MasterService())->deleteSpecializations($args['master_id'], $args['specializations_id']);
                }
            ],
        ];
    }

}