<?php

namespace api\controllers;

use api\graphql\TypeRegistry;
use api\graphql\site\registry\EntityTypeRegistry;
use api\graphql\site\registry\MutationInputTypeRegistry;
use api\graphql\site\types\QueryType;
use api\graphql\site\types\MutationType;

/**
 * Class CommonController
 *
 * @package api\controllers
 */
class SiteController extends GraphqlController
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