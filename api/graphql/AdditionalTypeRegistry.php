<?php

namespace api\graphql;

/**
 * Class AdditionalTypeRegistry
 *
 * @package api\graphql
 */
abstract class AdditionalTypeRegistry
{
    /**
     * @var TypeRegistry
     */
    protected $typeRegistry;

    /**
     * AdditionalTypeRegistry constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry)
    {
        $this->typeRegistry = $typeRegistry;
    }
}