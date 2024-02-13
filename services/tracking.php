<?php

class Tracking_Service
{
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_api_route'));
    }

    public function register_api_route(): void
    {
        register_rest_route('pb-configurator/v1', '/send-alert', array(
            'methods' => 'POST',
            'callback' => array($this, 'send_push_alert'),
            'args' => array(
                'id' => array(
                    'validate_callback' => array($this, 'check_validation')
                )
            ),
            'permission_callback' => '__return_true'
        ));
    }

    public function check_validation(): bool
    {
        return true;
    }

    public function track_form(): void
    {
        wp_enqueue_script('pushbullet-tracker', plugin_dir_url(__DIR__) . 'includes/tracker/tracker.js', array(), '1.0', true);
    }

    public static function send_sms_alert()
    {
        $message = Settings_Service::find_message()->value;
        $recipients = Settings_Service::find_phone_number()->value;
        $device_iden = Settings_Service::find_default_device()->value;

        if($message == "" || $recipients == "" || $device_iden == "") {
            return new WP_Error('error', 'Please configure the plugin first', array('status' => 412));
        }

        Text_Service::create([
            "data" => [
                "message" => $message,
                "addresses" => [$recipients],
                "target_device_iden" => $device_iden,
            ],
            "iden" => $device_iden
        ]);

        return rest_ensure_response('it worked');
    }

    public static function send_push_alert()
    {
        $message = Settings_Service::find_message()->value;
        $recipients = Settings_Service::find_phone_number()->value;
        $device_iden = Settings_Service::find_default_device()->value;

        if($message == "" || $recipients == "" || $device_iden == "") {
            return new WP_Error('error', 'Please configure the plugin first', array('status' => 412));
        }

        $mail = User_Service::get_data()['email'];

        Pushes_Service::create(
            [
                "type" => "note",
                "title" => "Alert",
                "body" => $message,
                "email" => $mail,
            ],
        );

        return rest_ensure_response('it worked');
    }
}