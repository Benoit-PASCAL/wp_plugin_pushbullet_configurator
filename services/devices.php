<?php

if (!defined('ABSPATH')) {
    exit; 
}

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

        if(array_key_exists('error',$response->decode_body()) || $response->decode_body()['devices'] == null)
        {
            return [];
        }

        $objects_list = [];

        foreach ($response->decode_body()['devices'] as $item)
        {
            $object = new stdClass();
            foreach ($item as $key => $value)
            {
                $object->$key = $value;
            }
            $objects_list[] = $object;
        }

        return $objects_list;
    }
}