<?php

namespace api\schema\type\scalar;

use GraphQL\Error\InvariantViolation;
use GraphQL\Type\Definition\ScalarType;

class UploadFileType extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'UploadFile';
    /**
     * @var string
     */
    public $description =
        'The `Upload` special type represents a file to be uploaded in the same HTTP request as specified by
 [graphql-multipart-request-spec](https://github.com/jaydenseric/graphql-multipart-request-spec).';
    /**
     * Serializes an internal value to include in a response.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function serialize($value)
    {
        throw new InvariantViolation('`Upload` cannot be serialized');
    }
    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function parseValue($value)
    {
        //throw new Error($value);
        /*
        if (!$value instanceof UploadedFileInterface) {
            throw new \UnexpectedValueException('Could not get uploaded file, be sure to conform to GraphQL multipart request specification. Instead got: ' . Utils::printSafe($value));
        }
        */
        return 123145;
    }
    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input
     *
     * @param \GraphQL\Language\AST\Node $valueNode
     * @param null|array $variables
     *
     * @return mixed
     */
    public function parseLiteral($valueNode, array $variables = null)
    {
        return $valueNode;
        //throw new Error('`Upload` cannot be hardcoded in query, be sure to conform to GraphQL multipart request specification. Instead got: ' . $valueNode->kind, [$valueNode]);
    }
}