<?php

class Pushes_Service {

    /**
     * @throws \WpOrg\Requests\Exception
     */
    static public function findAll(): array
    {
        $response = WpOrg\Requests\Requests::request(
            'https://api.pushbullet.com/v2/pushes?active=true',
            array(
                    'Access-Token' => Settings_Service::find_token()->value,
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache'
            )
        );

        if($response->decode_body()['pushes'] == null)
        {
            return [];
        }

        $objects_list = [];
        $object = new stdClass();

        foreach ($response->decode_body()['pushes'] as $key => $value)
        {
            $object->$key = $value;
            $objects_list[] = $object;
        }

        return $response->decode_body()['pushes'];
    }

    static public function create($data): void
    {
        WpOrg\Requests\Requests::post(
            'https://api.pushbullet.com/v2/pushes',
            array(
                'Access-Token' => Settings_Service::find_token()->value,
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache'
            ),
            json_encode($data)
        );
    }

    static public function delete($iden): void
    {
        WpOrg\Requests\Requests::delete(
            'https://api.pushbullet.com/v2/pushes/' . $iden,
            array(
                'Access-Token' => Settings_Service::find_token()->value,
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache'
            )
        );
    }
}