<?php

namespace api\schema\type\query;

use api\models\UserService;
use api\schema\TypeRegistry;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class SalonUserServiceType
 *
 * @package api\schema\type\query
 */
class SalonUserServiceType extends ObjectType implements QueryTypeInterface
{
    /**
     * SalonUserServiceType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'id' => $typeRegistry->id(),
                    'account_id' => $typeRegistry->id(),
                    'salon_id' => $typeRegistry->id(),
                    'user_id' => $typeRegistry->id(),
                    'service_id' => $typeRegistry->id(),
                ];
            }
        ]);
    }

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $queryRegistry = $typeRegistry->getQueryRegistry();

        return [
            'salonUserServices' => [
                'type' => $typeRegistry->listOff($queryRegistry->salonUserService()),
                'args' => [
                    'salon_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'user_id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return UserService::find()
                        ->where($args)
                        ->isAccount()
                        ->all();
                }
            ]
        ];
    }
}