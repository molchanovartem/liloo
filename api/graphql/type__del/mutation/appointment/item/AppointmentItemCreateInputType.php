<?php

namespace api\schema\type\mutation\appointment\item;

use api\schema\registry\TypeRegistry;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class AppointmentItemCreateInputType
 *
 * @package api\schema\type\mutation\appointment\item
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