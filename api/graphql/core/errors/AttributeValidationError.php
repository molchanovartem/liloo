<?php

namespace api\graphql\core\errors;

/**
 * Class AttributeValidationError
 *
 * @package api\graphql\core\errors
 */
class AttributeValidationError extends ValidationError
{
    /**
     * AttributeValidationError constructor.
     *
     * @param array $extensions
     */
    public function __construct(array $extensions)
    {
        parent::__construct('Attributes error', null, null, null, null, null, ['extensions' => $extensions]);
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return 'attributeValidation';
    }
}