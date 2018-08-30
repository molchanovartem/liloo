<?php

namespace api\schema;

use GraphQL\Error\Debug;
use GraphQL\Type\Schema;
use api\schema\registry\TypeRegistry;

/**
 * Class GraphQL
 *
 * @package api\schema
 */
class GraphQL
{
    private $query;

    private $variables;

    private $operation;

    private $typeRegistry;

    public function __construct($query, $variables = null, $operation = null)
    {
        $this->query = $query;
        $this->variables = $variables;
        $this->operation = $operation;

        $this->typeRegistry = new TypeRegistry();
    }

    public function getResult()
    {
        return \GraphQL\GraphQL::executeQuery(
            $this->getSchema(),
            $this->query,
            null,
            null,
            $this->variables,
            $this->operation
        )->toArray(Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE);
    }

    /**
     * @return Schema
     */
    private function getSchema()
    {
        return new Schema([
            'query' => $this->typeRegistry->query(),
            'mutation' => $this->typeRegistry->mutation()
        ]);
    }
}