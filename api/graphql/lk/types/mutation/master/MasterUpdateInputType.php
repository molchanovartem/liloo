<?php

namespace api\graphql\lk\types\mutation\master;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class MasterUpdateInputType
 *
 * @package api\graphql\lk\types\mutation\master
 */
class MasterUpdateInputType extends InputObjectType
{
    /**
     * MasterUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->string(),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'specializations_id' => $typeRegistry->listOff($typeRegistry->id())
                ];
            }
        ]);
    }
}