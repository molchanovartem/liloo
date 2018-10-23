<?php

namespace api\graphql\core;

/**
 * Interface MutationFieldsTypeInterface
 *
 * @package api\graphql\core
 */
interface MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array;
}