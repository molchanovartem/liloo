<?php

namespace site\events;

use yii\base\Event;

/**
 * Class RegistrationEvent
 *
 * @package site\events
 */
class RegistrationEvent extends Event
{
    public $login;

    public $phone;

    public $password;
}