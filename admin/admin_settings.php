<?php

class Admin_Settings
{
    public function render_content()
    {
        $table = Settings_Service::findAll();
        require_once PUSHBULLET_PLUGIN_DIR . 'templates/views/_settings.php';
    }

    public function save()
    {
        $settings = new Settings_Service();
        foreach ($_POST as $key => $value) {
            $settings->update($key, ["value" => $value]);
        }
    }
}