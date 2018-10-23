<?php

namespace api\graphql\site\services;

use common\models\Client;
use common\models\Salon;
use common\models\User;
use api\graphql\core\errors\AttributeValidationError;
use api\graphql\core\errors\NotFoundEntryError;
use api\graphql\core\errors\ValidationError;
use api\models\site\Appointment;

/**
 * Class AppointmentService
 *
 * @package api\graphql\site\services
 */
class AppointmentService extends \api\graphql\common\services\AppointmentService
{
    /**
     * @param array $attributes
     * @return bool
     * @throws NotFoundEntryError
     * @throws ValidationError
     * @throws \yii\db\Exception
     */
    public function create(array $attributes)
    {
        if (empty($attributes['user_id']) && empty($attributes['salon_id'])) throw new ValidationError('Isset user_id or salon_id');

        $model = new Appointment();

        if (!empty($attributes['user_id'])) {
            $model->setScenario(Appointment::SCENARIO_MASTER);
            $executor = User::find()
                ->select('account_id')
                ->byId($attributes['user_id'])
                ->byType(User::TYPE_EXECUTOR)
                ->asArray()
                ->one();
        } else {
            $model->setScenario(Appointment::SCENARIO_SALON);
            $executor = Salon::find()
                ->select('account_id')
                ->byId($attributes['salon_id'])
                ->asArray()
                ->one();
        }

        if (!$executor) throw new NotFoundEntryError();

        $attributes['account_id'] = $executor['account_id'];
        $attributes['status'] = \common\models\Appointment::STATUS_NEW;

        if (empty($attributes['client_id'])) {
            return (bool) $this->wrappedTransaction(function () use ($model, &$attributes) {
                $client = new Client([
                    'account_id' => $attributes['account_id'],
                    'country_id' => 1, // Russia
                    'status' => Client::STATUS_ACTIVE,
                    'name' => $attributes['client_name'] ?? null,
                    'phone' => $attributes['client_phone'] ?? null,
                ]);

                if (!$client->save()) throw new AttributeValidationError($client->getErrors());

                $attributes['client_id'] = $client->id;

                return $this->save($model, $attributes);
            });
        }
        return (bool) $this->save($model, $attributes);
    }
}