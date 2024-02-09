<?php

class Admin_Settings
{
    public function render_content(): void
    {
        $table = Settings_Service::findAll();

        require_once PUSHBULLET_PLUGIN_DIR . 'templates/views/_settings.php';
    }

    public function save(): bool
    {
        $settings = new Settings_Service();
        foreach ($_POST as $key => $value) {
            $formatted_value = sanitize_text_field($value);
            $settings->update($key, ["value" => $formatted_value]);
        }

        // return true if query was successfully executed
        return true;
    }
}