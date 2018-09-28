<?php

namespace api\graphql;

/**
 * Interface QueryTypeInterface
 *
 * @package api\graphql
 */
interface QueryTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array;
}