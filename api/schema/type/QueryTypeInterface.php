<?php

namespace api\schema\type;

use api\schema\registry\TypeRegistry;

/**
 * Interface QueryTypeInterface
 *
 * @package api\schema\type
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