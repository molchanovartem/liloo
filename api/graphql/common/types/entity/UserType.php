<?php

namespace api\graphql\common\types\entity;

use api\graphql\core\QueryTypeInterface;
use api\graphql\core\TypeRegistry;
use common\models\User;

/**
 * Class UserType
 *
 * @package api\graphql\common\types\entity
 */
class UserType extends \api\graphql\base\types\entity\UserType implements QueryTypeInterface
{
    /**
     * @return array
     */
    public function fields(): array
    {
        $fields = parent::fields();

        unset($fields['login']);
        return $fields;
    }

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();

        return [
            'user' => [
                'type' => $entityRegistry->user(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return User::findOne($args['id']);
                }
            ]
        ];
    }
}