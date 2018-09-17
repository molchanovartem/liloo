<?php

namespace api\graphql;

/**
 * Interface MutationFieldsTypeInterface
 *
 * @package api\graphql
 */
interface MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array;
}