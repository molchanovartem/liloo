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
     * QueryTypeInterface constructor.
     *
     * @param TypeRegistry $typeRegistry
     */
    public function __construct(TypeRegistry $typeRegistry);

    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getFieldsQueryType(TypeRegistry $typeRegistry): array;
}