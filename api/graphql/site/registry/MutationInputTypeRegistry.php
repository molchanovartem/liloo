<?php

namespace api\graphql\site\registry;

use api\graphql\core\AdditionalTypeRegistry;
use api\graphql\site\types\mutation\appointment\AppointmentCreateInputType;
use api\graphql\site\types\mutation\appointment\AppointmentItemCreateInputType;

/**
 * Class MutationInputTypeRegistry
 * @package api\graphql\site\registry
 */
class MutationInputTypeRegistry extends AdditionalTypeRegistry
{
    public function appointmentCreate()
    {
        return $this->typeRegistry->get(AppointmentCreateInputType::class);
    }

    public function appointmentItemCreate()
    {
        return $this->typeRegistry->get(AppointmentItemCreateInputType::class);
    }
}
