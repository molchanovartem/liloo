<?php

namespace api\schema\type\query;

use api\schema\TypeRegistry;

/**
 * Interface QueryTypeInterface
 *
 * @package api\schema\type\query
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