<?php

namespace api\graphql\base\types\scalar;

/**
 * Interface ValidationTypeInterface
 *
 * @package api\graphql\base\types\scalar
 */
interface ValidationTypeInterface
{
    public function validate($value);
}