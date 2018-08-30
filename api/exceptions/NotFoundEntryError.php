<?php

namespace api\exceptions;

use GraphQL\Error\Error;
use GraphQL\Language\Source;

class NotFoundEntryError extends Error
{
    public function __construct(string $message = '', $nodes = null, Source $source = null, array $positions = null, array $path = null, \Throwable $previous = null, array $extensions = [])
    {
        $message = $message !== '' ? $message : 'Not found entry';

        parent::__construct($message, $nodes, $source, $positions, $path, $previous, $extensions);
    }
}