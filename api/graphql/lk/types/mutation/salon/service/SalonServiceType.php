<?php

namespace api\graphql\lk\types\mutation\salon\service;

use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;
use api\services\lk\SalonService;

/**
 * Class SalonServiceType
 *
 * @package api\graphql\lk\types\mutation\salon\service
 */
class SalonServiceType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();
        $inputRegistry = $typeRegistry->getMutationRegistry();

        return [
            'salonServiceCreate' => [
                'type' => $entityRegistry->salonService(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->salonServiceCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->createSalonService($args['attributes']);
                }
            ],
            'salonServiceUpdate' => [
                'type' => $entityRegistry->salonService(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputRegistry->salonServiceUpdate())
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->updateSalonService($args['id'], $args['attributes']);
                }
            ],
            'salonServicesCreate' => [
                'type' => $typeRegistry->listOff($entityRegistry->salonService()),
                'args' => [
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($inputRegistry->salonServiceCreate()))
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->createSalonServices($args['items']);
                }
            ],
            'salonServicesUpdate' => [
                'type' => $typeRegistry->listOff($entityRegistry->salonService()),
                'args' => [
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($inputRegistry->salonServiceUpdateItems()))
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->updateSalonServices($args['items']);
                }
            ],
            'salonServiceDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->deleteSalonService($args['id']);
                }
            ],
            'salonServicesDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ],
                'resolve' => function ($root, $args) {
                    return (new SalonService())->deleteSalonServices($args['id']);
                }
            ],
        ];
    }
}