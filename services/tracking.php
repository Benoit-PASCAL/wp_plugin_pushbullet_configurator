<?php

class Tracking_Service
{
    public function track_form()
    {

        wp_enqueue_script('pushbullet-tracker', plugin_dir_url(__DIR__) . 'includes/js/tracker.js', array(), '1.0', true);
    }
}