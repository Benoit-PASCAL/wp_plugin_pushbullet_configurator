<?php

class Admin_Devices
{
    public function render_content()
    {
        $table = new Devices_List();
        require_once PUSHBULLET_PLUGIN_DIR . 'templates/views/_devices_list.php';
    }
}