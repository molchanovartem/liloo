<?php

namespace api\graphql\lk\types\mutation\master\schedule;

use api\graphql\core\TypeRegistry;
use api\graphql\core\MutationFieldsTypeInterface;
use api\graphql\lk\services\MasterService;

/**
 * Class MasterScheduleType
 *
 * @package api\graphql\lk\types\mutation\master\schedule
 */
class MasterScheduleType implements MutationFieldsTypeInterface
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
            'masterScheduleCreate' => [
                'type' => $entityRegistry->masterSchedule(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->masterScheduleCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->createMasterSchedule($args['attributes']);
                }
            ],
            'masterSchedulesCreate' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'items' => $typeRegistry->nonNull($typeRegistry->listOff($inputRegistry->masterScheduleCreate()))
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->createMasterSchedules($args['items']);
                }
            ],
            'masterScheduleUpdate' => [
                'type' => $entityRegistry->masterSchedule(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputRegistry->masterScheduleUpdate())
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->updateMasterSchedule($args['id'], $args['attributes']);
                }
            ],
            'masterScheduleDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return (new MasterService())->deleteMasterSchedule($args['id']);
                }
            ]
        ];
    }

}