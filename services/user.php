<?php

class User_Service {

    /**
     * @throws \WpOrg\Requests\Exception
     */
    static public function get_data(): array
    {
        $response = WpOrg\Requests\Requests::request(
            'https://api.pushbullet.com/v2/users/me',
            array(
                    'Access-Token' => Settings_Service::find_token()->value,
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache'
            )
        );

        return $response->decode_body();
    }
}