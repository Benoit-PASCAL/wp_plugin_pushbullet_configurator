<?php

class Text_Service {

    static public function create($data): void
    {
        WpOrg\Requests\Requests::post(
            'https://api.pushbullet.com/v2/texts',
            array(
                'Access-Token' => Settings_Service::find_token()->value,
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache'
            ),
            json_encode($data)
        );
    }
}