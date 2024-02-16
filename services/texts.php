<?php

class Text_Service {

    static public function create($data)
    {
        $response = WpOrg\Requests\Requests::post(
            'https://api.pushbullet.com/v2/texts',
            array(
                'Access-Token' => Settings_Service::find_token()->value,
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache'
            ),
            json_encode($data)
        );

        if($response->status_code != 200)
        {
            $error = json_decode($response->body)->error;
            return new WP_Error('error', 'Text could not be sent : ' . $error->message, array('status' => $response->status_code));
        }

        return $response;
    }
}