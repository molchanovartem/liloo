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
        $ch = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address");

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'query' => $address,
            'count' => 0
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Token c3a8b2b9d51dc0a418f62a0c4579aaedb95e40c6'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if (!empty($result['suggestions'][0]['data'])) return [
            'latitude' => $result['suggestions'][0]['data']['geo_lat'],
            'longitude' => $result['suggestions'][0]['data']['geo_lon']
        ];

        return null;
    }
}