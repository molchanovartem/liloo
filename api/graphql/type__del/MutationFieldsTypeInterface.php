<?php

namespace api\schema\type;

use api\schema\registry\TypeRegistry;

/**
 * Interface MutationFieldsTypeInterface
 *
 * @package api\schema\type
 */
interface MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array;
}