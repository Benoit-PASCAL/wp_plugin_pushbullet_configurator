<?php

class Devices_Service {

    /**
     * @throws \WpOrg\Requests\Exception
     */
    static public function findAll(): array
    {
        $response = WpOrg\Requests\Requests::request(
            'https://api.pushbullet.com/v2/devices',
            array(
                    'Access-Token' => Settings_Service::find_token()->value,
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache'
            )
        );

        if($response->decode_body()['devices'] == null)
        {
            return [];
        }

        $objects_list = [];
        $object = new stdClass();

        foreach ($response->decode_body()['devices'] as $key => $value)
        {
            $object->$key = $value;
            $objects_list[] = $object;
        }

        return $response->decode_body()['devices'];
    }
}