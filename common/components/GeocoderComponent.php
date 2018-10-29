<?php

namespace common\components;

use yii\base\BaseObject;

/**
 * Class GeocoderComponent
 *
 * @package common\components
 */
class GeocoderComponent extends BaseObject
{
    public function getCoordinate($address)
    {
//        curl -X POST
//    -H "Content-Type: application/json"
//    -H "Accept: application/json"
//    -H "Authorization: Token 70b7592418c7e7dbb82f3c09843f18a24d1ef037"
//    -d '{ "query": "Викт" }'
//    https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/fio

        // Запрос через curl
    }
}