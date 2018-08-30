<?php

namespace api\schema\type\mutation\serviceGroup;

use api\schema\registry\TypeRegistry;
use api\schema\type\MutationFieldsTypeInterface;
use api\services\ServiceService;

/**
 * Class ServiceGroupType
 *
 * @package api\schema\type\mutation\serviceGroup
 */
class ServiceGroupType implements MutationFieldsTypeInterface
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
           'serviceGroupCreate' => [
               'type' => $entityRegistry->serviceGroup(),
               'args' => [
                   'attributes' => $typeRegistry->nonNull($inputRegistry->serviceGroupCreate()),
               ],
               'resolve' => function ($root, $args, $context, $info) {
                   return (new ServiceService())->createGroup($args['attributes']);
               }
           ],
           'serviceGroupUpdate' => [
               'type' => $entityRegistry->serviceGroup(),
               'args' => [
                   'id' => $typeRegistry->nonNull($typeRegistry->id()),
                   'attributes' => $typeRegistry->nonNull($inputRegistry->serviceGroupUpdate()),
               ],
               'resolve' => function ($root, $args, $context, $info) {
                   return (new ServiceService())->updateGroup($args['id'], $args['attributes']);
               }
           ],
           'serviceGroupDelete' => [
               'type' => $typeRegistry->boolean(),
               'args' => [
                   'id' => $typeRegistry->nonNull($typeRegistry->id())
               ],
               'resolve' => function ($root, $args) {
                   return (new ServiceService())->deleteGroup($args['id']);
               }
           ],
       ];
    }
}