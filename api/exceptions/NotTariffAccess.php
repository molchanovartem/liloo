<?php

namespace api\exceptions;

use GraphQL\Error\Error;
use GraphQL\Language\Source;

/**
 * Class NotTariffAccess
 *
 * @package api\exceptions
 */
class NotTariffAccess extends Error
{
    /**
     * ForbiddenError constructor.
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
        $message = $message !== '' ? $message : 'Not access';

        parent::__construct($message, $nodes, $source, $positions, $path, $previous, $extensions);
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return 'tariff access'; // ???
    }
}