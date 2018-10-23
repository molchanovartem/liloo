<?php

namespace api\graphql\core;

/**
 * Class AdditionalTypeRegistry
 *
 * @package api\graphql\core
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