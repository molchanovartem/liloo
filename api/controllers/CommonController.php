<?php

namespace api\controllers;

use api\graphql\TypeRegistry;
use api\graphql\common\registry\EntityTypeRegistry;
use api\graphql\common\registry\MutationInputTypeRegistry;
use api\graphql\common\types\QueryType;
use api\graphql\common\types\MutationType;

/**
 * Class CommonController
 *
 * @package api\controllers
 */
class CommonController extends GraphqlController
{
    /**
     * @throws \Exception
     */
    public function init()
    {
        $this->typeRegistry = new TypeRegistry(
            EntityTypeRegistry::class,
            MutationInputTypeRegistry::class,
            QueryType::class,
            MutationType::class
        );
        parent::init();
    }
}