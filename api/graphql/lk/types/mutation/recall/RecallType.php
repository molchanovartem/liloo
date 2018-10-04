<?php

namespace api\graphql\lk\types\mutation\recall;

use common\models\Recall;
use api\graphql\TypeRegistry;
use api\graphql\MutationFieldsTypeInterface;
use api\services\lk\RecallService;

/**
 * Class RecallType
 *
 * @package api\graphql\lk\types\mutation\recall
 */
class RecallType implements MutationFieldsTypeInterface
{
    /**
     * @param TypeRegistry $typeRegistry
     * @return array
     */
    public static function getMutationFieldsType(TypeRegistry $typeRegistry): array
    {
        $entityRegistry = $typeRegistry->getEntityRegistry();
        $inputRegistry = $typeRegistry->getMutationRegistry();

        return [
            'recallCreate' => [
                'type' => $entityRegistry->recall(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->recallCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new RecallService())->create($args['attributes'], Recall::RECALL_TYPE_USER, Recall::SCENARIO_DEFAULT);
                }
            ],
            'recallResponseCreate' => [
                'type' => $entityRegistry->recall(),
                'args' => [
                    'attributes' => $typeRegistry->nonNull($inputRegistry->recallResponseCreate())
                ],
                'resolve' => function ($root, $args) {
                    return (new RecallService())->create($args['attributes'], Recall::RECALL_TYPE_MASTER_RESPONSE, Recall::SCENARIO_ANSWER);
                }
            ],
            'recallDelete' => [
                'type' => $typeRegistry->boolean(),
                'args' => [
                    'id' => $typeRegistry->nonNull($typeRegistry->id())
                ],
                'resolve' => function ($root, $args) {
                    return (new RecallService())->delete($args['id']);
                }
            ]
        ];
    }
}