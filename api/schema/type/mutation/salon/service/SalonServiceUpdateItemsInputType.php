<?php

namespace api\schema\type\mutation\salon\service;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class SalonServiceUpdateItemsInputType
 *
 * @package api\schema\type\mutation\salon\service
 */
class SalonServiceUpdateItemsInputType extends InputObjectType
{
    /**
     * SalonServiceUpdateItemsInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $inputRegistry = $typeRegistry->getMutationInputRegistry();

        parent::__construct([
            'fields' => function () use ($typeRegistry, $inputRegistry) {
                return [
                    'id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'attributes' => $typeRegistry->nonNull($inputRegistry->salonServiceUpdate())
                ];
            }
        ]);
    }
}