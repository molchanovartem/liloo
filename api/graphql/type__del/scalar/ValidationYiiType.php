<?php

namespace api\schema\type\scalar;

use yii\validators\Validator;
use GraphQL\Type\Definition\ScalarType;
use api\schema\type\ValidationTypeInterface;

/**
 * Class ValidationYiiType
 *
 * @package api\schema\type\scalar
 */
abstract class ValidationYiiType extends ScalarType implements ValidationTypeInterface
{
    /**
     * @var null
     */
    protected $validatorClass = null;
    /**
     * @var Validator
     */
    protected $validator;
    /**
     * @var string
     */
    protected $error = '';
    /**
     * @var array
     */
    protected $params = [];

    public function __construct()
    {
        if ($this->validatorClass === null) {
            throw new \Error('No set validatorClass');
        }

        $className = $this->validatorClass;
        $this->validator = new $className($this->params);

        parent::__construct($config = []);
    }

    public function serialize($value)
    {
        return $value;
    }

    public function parseValue($value)
    {
        if ($this->validate($value)) return $value;
    }

    public function parseLiteral($valueNode, array $variables = null)
    {
        if ($this->validate($valueNode->value)) return $valueNode->value;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value): bool
    {
        if (!$this->validator->validate($value, $this->error)) {
            throw new \UnexpectedValueException($this->error);
        }
        return true;
    }
}