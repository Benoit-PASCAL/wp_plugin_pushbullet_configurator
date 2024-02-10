<?php

class Admin_Devices
{
    public function render_content(): void
    {
        if(isset($_GET['action']) && $_GET['action'] == 'use' && isset($_GET['iden'])) {
            $iden = sanitize_text_field($_GET['iden']);
            Settings_Service::set_default_device($iden);
        }

        $table = new Devices_List();
        require_once PUSHBULLET_PLUGIN_DIR . 'templates/views/_devices_list.php';
    }
}