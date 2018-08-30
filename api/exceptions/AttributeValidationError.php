<?php

namespace api\exceptions;

/**
 * Class AttributeValidationError
 *
 * @package api\exceptions
 */
class AttributeValidationError extends ValidationError
{
    public function __construct(array $extensions)
    {
        parent::__construct('Attributes error', null, null, null, null, null, ['extensions' => $extensions]);
    }
}