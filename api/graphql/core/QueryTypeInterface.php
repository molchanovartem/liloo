<?php

namespace api\graphql\core;

/**
 * Interface QueryTypeInterface
 *
 * @package api\graphql\core
 */
interface QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array;
}