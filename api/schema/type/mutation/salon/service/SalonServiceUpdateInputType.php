<?php

namespace api\schema\type\mutation\salon\service;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**\
 * Class SalonServiceUpdateInputType
 *
 * @package api\schema\type\mutation\salon\service
 */
class SalonServiceUpdateInputType extends InputObjectType
{
    /**
     * SalonServiceUpdateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'service_price' => $typeRegistry->decimal(),
                    'service_duration' =>$typeRegistry->int()
                ];
            }
        ]);
    }
}