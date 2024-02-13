<?php

class Admin_Devices
{
    public function render_content(): void
    {
        if(isset($_GET['action']) && $_GET['action'] == 'use' && isset($_GET['iden'])) {
            $iden = sanitize_text_field($_GET['iden']);
            Settings_Service::set_default_device($iden);
        }

        if(isset($_GET['action']) && $_GET['action'] == 'test-alert') {
            if(isset($_GET['type']) && $_GET['type'] == 'sms') {
                Tracking_Service::send_sms_alert();
                echo '<div class="notice notice-success is-dismissible"><p>Alert sent</p></div>';
            }
            else if(isset($_GET['type']) && $_GET['type'] == 'push') {
                Tracking_Service::send_push_alert();
                echo '<div class="notice notice-success is-dismissible"><p>Alert sent</p></div>';
            }
            else {
                echo '<div class="notice notice-error is-dismissible"><p>An error occurred while trying to send alert</p></div>';
            }

        }

        $table = new Devices_List();
        require_once PUSHBULLET_PLUGIN_DIR . 'templates/views/_devices_list.php';
    }
}