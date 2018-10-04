<?php

namespace api\controllers;

use yii\filters\auth\HttpBearerAuth;
use api\graphql\lk\MutationTypeRegistry;
use api\graphql\lk\types\MutationType;
use api\graphql\lk\types\QueryType;
use api\graphql\TypeRegistry;
use api\graphql\lk\EntityTypeRegistry;

/**
 * Class lkController
 *
 * @package api\controllers
 */
class LkController extends GraphqlController
{
    /**
     * @throws \Exception
     */
    public function init()
    {
        $this->typeRegistry = new TypeRegistry(
            EntityTypeRegistry::class,
            MutationTypeRegistry::class,
            QueryType::class,
            MutationType::class
        );

        parent::init();
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return array_merge_recursive(parent::behaviors(), [
            'bearerAuth' => [
                'class' => HttpBearerAuth::class,
            ]
        ]);
    }
}