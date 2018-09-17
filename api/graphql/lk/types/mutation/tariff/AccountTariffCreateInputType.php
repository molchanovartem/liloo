<?php

namespace api\graphql\lk\types\mutation\tariff;

use GraphQL\Type\Definition\InputObjectType;
use api\graphql\TypeRegistry;

/**
 * Class AccountTariffCreateInputType
 *
 * @package api\graphql\lk\types\mutation\tariff
 */
class AccountTariffCreateInputType extends InputObjectType
{
    /**
     * AccountTariffCreateInputType constructor.
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        parent::__construct([
            'fields' => function () use ($typeRegistry) {
                return [
                    'tariff_id' => $typeRegistry->nonNull($typeRegistry->id()),
                    'price_id' => $typeRegistry->nonNull($typeRegistry->id()),
                ];
            }
        ]);
    }
}
