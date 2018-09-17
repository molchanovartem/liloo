<?php

namespace api\graphql\lk\types\mutation\appointment\item;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class AppointmentItemCreateInputType
 *
 * @package api\graphql\lk\types\mutation\appointment\item
 */
class AppointmentItemCreateInputType extends InputObjectType
{
    /**
     * AppointmentItemCreateInputType constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'service_id' => $typeRegistry->nonNull($typeRegistry->int()),
                    'quantity' => $typeRegistry->nonNull($typeRegistry->int())
                ];
            }
        ]);
    }
}