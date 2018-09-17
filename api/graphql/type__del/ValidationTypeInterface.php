<?php

namespace api\schema\type;

/**
 * Interface ValidationTypeInterface
 *
 * @package api\schema\type
 */
interface ValidationTypeInterface
{
    public function validate($value);
}