<?php

namespace api\graphql\core\errors;

use GraphQL\Error\Error;
use GraphQL\Language\Source;

/**
 * Class NotFoundEntryError
 *
 * @package api\graphql\core\errors
 */
class NotFoundEntryError extends Error
{
    /**
     * NotFoundEntryError constructor.
     *
     * @param string $message
     * @param null $nodes
     * @param Source|null $source
     * @param array|null $positions
     * @param array|null $path
     * @param \Throwable|null $previous
     * @param array $extensions
     */
    public function __construct(string $message = '', $nodes = null, Source $source = null, array $positions = null, array $path = null, \Throwable $previous = null, array $extensions = [])
    {
        $message = $message !== '' ? $message : 'Not found entry';

        parent::__construct($message, $nodes, $source, $positions, $path, $previous, $extensions);
    }

    /*
     * @todo
     * Category
     */
}