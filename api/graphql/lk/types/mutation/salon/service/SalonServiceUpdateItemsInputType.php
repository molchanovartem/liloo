<?php

namespace api\graphql\lk\types\mutation\salon\service;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\core\TypeRegistry;

/**
 * Class SalonServiceUpdateItemsInputType
 *
 * @package api\graphql\lk\types\mutation\salon\service
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
        $inputRegistry = $typeRegistry->getMutationRegistry();

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