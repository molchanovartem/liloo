<?php

namespace api\exceptions;

use GraphQL\Error\Error;
use GraphQL\Language\Source;

/**
 * Class ValidationError
 *
 * @package api\exceptions
 */
class ValidationError extends Error
{
    /**
     * ValidationError constructor.
     *
     * @param string $message
     * @param null $nodes
     * @param Source|null $source
     * @param array|null $positions
     * @param array|null $path
     * @param \Throwable|null $previous
     * @param array $extensions
     */
    public function __construct(string $message, $nodes = null, Source $source = null, array $positions = null, array $path = null, \Throwable $previous = null, array $extensions = [])
    {
        parent::__construct($message, $nodes, $source, $positions, $path, $previous, $extensions);
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return 'validation';
    }
}