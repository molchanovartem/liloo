<?php

namespace api\schema\type\mutation\master;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class MasterCreateInputType
 *
 * @package api\schema\type\mutation\master
 */
class MasterCreateInputType extends InputObjectType
{
    /**
     * MasterCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'surname' => $typeRegistry->string(),
                    'name' => $typeRegistry->nonNull($typeRegistry->string()),
                    'patronymic' => $typeRegistry->string(),
                    'date_birth' => $typeRegistry->date(),
                    'specializations_id' => $typeRegistry->nonNull($typeRegistry->listOff($typeRegistry->id()))
                ];
            }
        ]);
    }
}