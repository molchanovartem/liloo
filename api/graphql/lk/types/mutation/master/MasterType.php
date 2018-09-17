<?php

namespace api\graphql\lk\types\mutation\master;

use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;
use api\services\MasterService;

/**
 * Class MasterType
 *
 * @package api\graphql\lk\types\mutation\master
 */
class MasterType implements MutationFieldsTypeInterface
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
            'masterCreate' => [
                'type' => $entityRegistry->master(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->masterCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->create($args['attributes']);
                }
            ],
            'masterUpdate' => [
                'type' => $entityRegistry->master(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputRegistry->masterUpdate())
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->update($args['id'], $args['attributes']);
                }
            ],
            'masterDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->delete($args['id']);
                }
            ]
        ];
    }

}