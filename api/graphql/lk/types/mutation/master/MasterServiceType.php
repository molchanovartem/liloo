<?php

namespace api\graphql\lk\types\mutation\master;

use api\graphql\lk\services\MasterService;
use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;

/**
 * Class MasterServiceType
 *
 * @package api\graphql\lk\types\mutation\master
 */
class MasterServiceType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        return [
            'masterServicesCreate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'services_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->createServices($args['master_id'], $args['salon_id'], $args['services_id']);
                }
            ],
            'masterServicesUpdate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'services_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->updateServices($args['master_id'], $args['salon_id'], $args['services_id']);
                }
            ],
            'masterServicesDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'master_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'services_id' => [
                        'type' => $typeRegistry->listOff($typeRegistry->id()),
                        'defaultValue' => []
                    ]
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->deleteServices($args['master_id'], $args['salon_id'], $args['services_id']);
                }
            ]
        ];
    }
}