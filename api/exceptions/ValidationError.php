<?php

namespace api\exceptions;

use GraphQL\Error\Error;
use GraphQL\Language\Source;

class ValidationError extends Error
{
    public function __construct(string $message, $nodes = null, Source $source = null, array $positions = null, array $path = null, \Throwable $previous = null, array $extensions = [])
    {
        parent::__construct($message, $nodes, $source, $positions, $path, $previous, $extensions);
    }

    public function getCategory()
    {
        return 'validation';
    }
}