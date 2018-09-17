<?php

namespace api\graphql\types\scalar;

/**
 * Interface ValidationTypeInterface
 *
 * @package api\graphql\types\scalar
 */
interface ValidationTypeInterface
{
    public function validate($value);
}