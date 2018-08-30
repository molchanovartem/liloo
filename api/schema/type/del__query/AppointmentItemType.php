<?php

namespace api\schema\type\query;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class AppointmentItemType
 *
 * @package api\schema\query
 */
class AppointmentItemType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function () {
                return [
                    'id' => Type::int(),
                    'account_id' => Type::int(),
                    'appointment_id' => Type::int(),
                    'service_id' => Type::int(),
                    'service_name' => Type::string(),
                    'service_price' => Type::string(),
                    'service_duration' => Type::string(),
                    'quantity' => Type::int()
                ];
            }
        ];

        parent::__construct($config);
    }
}